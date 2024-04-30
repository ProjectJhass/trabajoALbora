<?php

namespace App\Http\Controllers\apps\control_madera;

use App\Http\Controllers\Controller;
use App\Models\apps\control_madera\ModelConsecutivosMadera;
use Illuminate\Http\Request;

class ControllerSearchMadera extends Controller
{
    public function findCombinations($id, $pulgadas)
    {
        $span = '';
        $ids = '';

        $target = $pulgadas;
        $combinations = [];
        $found = false;
        $resultado = array();
        $sum_pulgadas = 0;

        $records = ModelConsecutivosMadera::where('estado', 'Activo')->orderBy('pulgadas', 'asc')->get();

        // Encuentra las combinaciones que suman el total deseado
        $this->findCombinationUtil($records, $target, [], $combinations, $found);

        // Si se encontró al menos una combinación válida, mostrarla
        if (!empty($combinations)) {

            for ($i = 0; $i < count($combinations[0]['id']); $i++) {
                $nuevoElemento = array(
                    'id' => $combinations[0]['id'][$i],
                    'pulgada' => $combinations[0]['pulgadas'][$i],
                    'madera' => $combinations[0]['madera'][$i]
                );
                $resultado[] = $nuevoElemento;
            }

            foreach ($resultado as $key => $value) {
                $span .= '<span class="badge badge-pill badge-secondary" style="cursor:pointer" id="' . $id . $value['id'] . ' - ' . number_format($value['pulgada']) . '″ ' . $value['madera'] . '" onclick="deleteTronco(' . $id . ',\'' . $value['id'] . ' - ' . number_format($value['pulgada']) . '″ ' . $value['madera'] . '\')" >' . $value['id'] . ' - ' . number_format($value['pulgada']) . '″ ' . $value['madera'] . '</span>';
                // $span .= '<span class="badge badge-pill badge-secondary" style="cursor:pointer" id="' . $id . number_format($value) . '" onclick="deleteTronco(' . $id . ',' . number_format($value) . ')" >' . number_format($value) . '″</span>\t';
                $ids .= $value['id'] . ' - ' . number_format($value['pulgada']) . '″ ' . $value['madera'] . ',';
                $sum_pulgadas += number_format($value['pulgada']);
            }
            ModelConsecutivosMadera::whereIn('id', $combinations[0]['id'])->update(['estado' => 'En uso']);
            //$ids = implode(",", $combinations[0]['id']);
        }

        return ([$span, $ids, $sum_pulgadas]);
    }

    // Función para encontrar las combinaciones
    private function findCombinationUtil($records, $target, $data, &$combinations, &$found, $start = 0, $index = 0)
    {
        // Si ya se encontró una combinación válida, salir
        if ($found) {
            return;
        }

        // Si la suma de los elementos en $data es igual a $target, agrega $data a $combinations
        if ($index == $target) {
            $ids = array_column($data, 'id');
            $pulgadas = array_column($data, 'pulgadas');
            $tipo = array_column($data, 'tipo_madera');
            $combination = [
                'id' => $ids,
                'pulgadas' => $pulgadas,
                'madera' => $tipo
            ];
            $combinations[] = $combination;
            $found = true; // Marcar que se ha encontrado una combinación válida
            return;
        }

        // Encuentra la combinación recursivamente
        for ($i = $start; $i < count($records) && $index + $records[$i]->pulgadas <= $target; $i++) {
            // Agrega el elemento actual al array $data
            $data[] = ['id' => $records[$i]->id, 'pulgadas' => $records[$i]->pulgadas, 'tipo_madera' => $records[$i]->tipo_madera];
            // Llama recursivamente a findCombinationUtil con el nuevo $data y $index
            // pero inicia la búsqueda desde $i + 1 para evitar repetir registros en la combinación
            $this->findCombinationUtil($records, $target, $data, $combinations, $found, $i + 1, $index + $records[$i]->pulgadas);
            // Remueve el último elemento para probar otras combinaciones
            array_pop($data);
        }
    }


    public function search(Request $request)
    {
        $id_ = $request->id;
        $pulgadas = $request->pulgadas;
        $troncos = $request->troncos;

        if (!empty($troncos)) {

            $ids_ = [];

            $troncos = preg_replace('/^,|,(?=,|$)/', '', $troncos);

            $troncos = str_replace("″", "", $troncos);
            $troncos = explode(",", $troncos);
            foreach ($troncos as $key => $value) {
                $id_s = explode("-", $value);
                array_push($ids_, $id_s[0]);
            }

            ModelConsecutivosMadera::whereIn('id', $ids_)->update(['estado' => 'Activo']);
        }

        $form_ = '<option value=""></option>';
        $response = self::findCombinations($id_, $pulgadas);
        $troncos = ModelConsecutivosMadera::where('estado', 'Activo')->orderBy('pulgadas', 'asc')->get();
        foreach ($troncos as $key => $value) {
            $form_ .= '<option value="' . $value->id . ' - ' . number_format($value->pulgadas) . '″ ' . $value->tipo_madera . '">' . $value->id . ' - ' . number_format($value->pulgadas) . '″ ' . $value->tipo_madera . '</option>';
        }

        $span_ = empty($response[0]) ? '¡Seleccionar manualmente!' : $response[0];

        return response()->json(['span' => $span_, 'ids' => $response[1], 'pulgadas' => $form_, 'sum_p' => $response[2]], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }

    public function changeEstadoTroco(Request $request)
    {
        $valor = $request->valor;
        $estado = $request->estado;

        $info_ = explode("-", $valor);
        $id = trim($info_[0]);
        $data_ = ModelConsecutivosMadera::find($id);
        switch ($estado) {
            case '1': //Actualizar en uso
                $data_->estado = 'En uso';
                $data_->save();
                break;
            case '2': //Actualizar disponible
                $data_->estado = 'Activo';
                $data_->save();
                break;
        }
        $form_ = '<option value=""></option>';
        $troncos = ModelConsecutivosMadera::where('estado', 'Activo')->orderBy('pulgadas', 'asc')->get();
        foreach ($troncos as $key => $value) {
            $form_ .= '<option value="' . $value->id . ' - ' . number_format($value->pulgadas) . '″ ' . $value->tipo_madera . '">' . $value->id . ' - ' . number_format($value->pulgadas) . '″ ' . $value->tipo_madera . '</option>';
        }

        return response()->json(['options' => $form_], 200, ['Content-type' => 'application/json', 'charset' => 'utf-8']);
    }
}
