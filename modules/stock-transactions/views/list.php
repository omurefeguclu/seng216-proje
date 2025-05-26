<?php setLayout('layout'); ?>

<?= renderPartial('breadcrumb', [
    'breadcrumb' => [['Stock Transactions', '/stock-transactions']],
]) ?>

<!-- Header with search -->
<div class="bg-primary text-white p-4">
    <div class="container-lg d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button class="btn d-md-none" data-bs-toggle="offcanvas" data-bs-target="#side-nav">
                <svg class="bi icon-md" style="fill: white;"><use xlink:href="#list"></use></svg>
            </button>
            <h4 class="mb-0">Stock Transactions</h4>
        </div>

        <div class="d-flex justify-content-center align-items-center gap-2" data-datatable-filter-group="#stock-transactions-table">

            <select class="form-select" name="WarehouseId"
                    data-datasource="/api/warehouses/get-dropdown">
                <option value="">Search by warehouse</option>
            </select>
            <select class="form-select" name="VehicleId"
                    data-datasource="/api/vehicles/get-dropdown">
                <option value="">Search by vehicle</option>
            </select>

            <button class="btn btn-secondary bg-secondary" style="min-width: 140px;" data-form-modal-button="#stock-transaction-form-modal">
                <svg class="bi me-1" ><use xlink:href="#plus-circle"></use> </svg>
                New Stock Transaction
            </button>
        </div>
    </div>

</div>

<!-- Table with accordion rows and buttons -->
<div class="container-lg p-4">

    <?= renderPartial("_table") ?>


</div>



<?php
$viewEngine->startCustomScripts();
?>

<script type="text/javascript">
    const stockTransactionsTable = initDatatable('#stock-transactions-table', '/api/stock-transactions');

    initFormModal('#stock-transaction-form-modal', stockTransactionsTable, {
        createTitle: 'Create new Stock Transaction',
        updateTitle: 'Update Stock Transaction',
    });

</script>

<?php
$viewEngine->endCustomScripts();
?>

