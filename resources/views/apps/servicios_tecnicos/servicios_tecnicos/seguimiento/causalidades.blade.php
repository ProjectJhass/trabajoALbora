<div class="container">
    {{-- {{json_encode($data_)}} --}}
    <div class="chart-container">
        <canvas id="myPieChart" width="400px" height="400px" data-data="{{ json_encode($data) }}"></canvas>

    </div>
    <div class="legend-container" id="legend"></div>
</div>
<style>
    .container {
        display: flex;
    }

    .legend-container {
        height: 400px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        padding-left: 20px;
        flex-wrap: wrap;
    }

    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }

    .legend-color {
        width: 20px;
        height: 20px;
        margin-right: 5px;
    }

    .legend-text {
        font-size: 14px;
    }
    .ledend-quantity{
        text-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
    }
</style>
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script src="./../../js/causalidades.js"></script>
