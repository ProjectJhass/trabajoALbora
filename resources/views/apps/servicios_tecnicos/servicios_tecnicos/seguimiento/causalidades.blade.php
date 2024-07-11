<div class="container">
    <div class="chart-container">
        <canvas id="myPieChart" width="400px" height="400px" data-data="{{ json_encode($data) }}"></canvas>
    </div>
    <div class="legend-container" id="legend"></div>
</div>
<footer>
    <div class="modal fade" id="ModalDetalleCausalidad" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100" id="exampleModalLabel4"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</footer>
