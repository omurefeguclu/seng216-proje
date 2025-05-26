<?php setLayout('layout'); ?>



<!-- Table with accordion rows and buttons -->
<div class="container-lg p-4">

    <?= renderPartial('breadcrumb', [
        'breadcrumb' => [['Dashboard', '/dashboard']],
    ]) ?>

    <div class="row dashboard-cards g-4">
        <div class="col-md-4">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="display-6 text-primary" id="totalProducts">
                        <?= $TotalProducts ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Warehouses</h5>
                    <p class="display-6 text-success" id="totalWarehouses">
                        <?= $TotalWarehouses ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-info shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Vehicles</h5>
                    <p class="display-6 text-info" id="totalVehicles">
                        <?= $TotalVehicles ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="d-flex flex-row justify-content-between align-items-center mb-2 w-100">
            <span class="h4">Stock Transactions</span>
            <div class="d-flex flex-row">
                <button class="btn btn-primary me-1" data-form-modal-button="#stock-transaction-form-modal">
                    <i class="bi bi-plus-circle"></i>
                    New Stock Transaction
                </button>
            </div>
        </div>
        <?= renderPartial('../../stock-transactions/views/_table'); ?>
    </div>



</div>


<?php $viewEngine->startCustomScripts(); ?>
    <script type="text/javascript">
        const stockTransactionsTable = initDatatable('#stock-transactions-table', '/api/stock-transactions');

        initFormModal('#stock-transaction-form-modal', stockTransactionsTable, {
            createTitle: 'Create new Stock Transaction',
            updateTitle: 'Update Stock Transaction',
        });
    </script>
<?php $viewEngine->endCustomScripts(); ?>