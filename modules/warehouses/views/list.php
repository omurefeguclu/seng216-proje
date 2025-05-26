<?php setLayout('layout'); ?>

<?= renderPartial('breadcrumb', [
    'breadcrumb' => [['Warehouses', '/warehouses']],
]) ?>

<!-- Header with search -->
<div class="bg-primary text-white p-4">
    <div class="container-lg d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button class="btn d-md-none" data-bs-toggle="offcanvas" data-bs-target="#side-nav">
                <svg class="bi icon-md" style="fill: white;"><use xlink:href="#list"></use></svg>
            </button>
            <h4 class="mb-0">Warehouses</h4>
        </div>

        <div class="d-flex justify-content-center align-items-center gap-2" data-datatable-filter-group="#entities-table">
            <input name="Name" class="form-control " style="min-width: 160px; max-width: 240px; field-sizing: content;" type="search" placeholder="Search for Warehouse Name...">

            <button class="btn btn-secondary bg-secondary" style="min-width: 140px;" data-form-modal-button="#entity-form-modal">
                <svg class="bi me-1" ><use xlink:href="#plus-circle"></use> </svg>
                New Warehouse
            </button>
        </div>
    </div>

</div>

<!-- Table with accordion rows and buttons -->
<div class="container-lg p-4">

    <div class="card shadow-sm rounded-4 border-0">
        <div class="table-responsive">
            <table id="entities-table" data-paginator="#entities-pagination"
                   class="table data-table table-striped table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col" class="d-none d-sm-table-cell">Last Updated</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <tr data-row-template>
                    <td data-content-binding="Id">1</td>
                    <td data-content-binding="Name">Widget A</td>
                    <td data-content-binding="CreatedOn" data-binding-func="formatDate" class="d-none d-sm-table-cell">2025-05-21</td>
                    <td>
                        <button data-form-modal-button="#entity-form-modal" data-attr-binding-target="data-entity-id" data-attr-binding="Id"
                                class="btn btn-sm btn-primary me-1">
                            <svg class="bi"><use xlink:href="#pencil"></use> </svg>
                        </button>
                        <button data-detail-button data-attr-binding-target="data-entity-id" data-attr-binding="Id"
                                class="btn btn-sm btn-primary me-1">
                            <svg class="bi"><use xlink:href="#list"></use> </svg>
                        </button>
                        <button data-delete-button data-attr-binding-target="data-entity-id" data-attr-binding="Id"
                                class="btn btn-sm btn-danger">
                            <svg class="bi"><use xlink:href="#trash"></use> </svg>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="card-body py-2 px-3 d-flex justify-content-end align-items-center">


            <!-- Pagination -->
            <nav>
                <ul data-pagination id="entities-pagination" class="pagination rounded-2 overflow-hidden justify-content-end mb-0">
                    <li data-active-page-template class="page-item active"><a class="page-link" href="#" data-page>1</a></li>
                    <li data-page-template class="page-item"><a class="page-link" href="#" data-page>1</a></li>
                </ul>
            </nav>
        </div>
    </div>


</div>

<div class="modal fade" id="entity-form-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Create Warehouse</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="warehouseName" class="form-label">Warehouse Name</label>
                        <input type="text" class="form-control" name="Name" id="warehouseName"
                               placeholder="Enter warehouse name" data-validate="isRequired('You must enter a name')">
                    </div>
                    <button type="submit" class="btn btn-success">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="stock-log-form-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Create Unknown Stock Log</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="WarehouseId" id="stockLogWarehouseId">
                    <div class="mb-3">
                        <label for="stockLogProductSelect" class="form-label">Product</label>
                        <select class="form-select" name="ProductId" id="stockLogProductSelect" data-datasource="/api/products/get-dropdown"
                                data-validate="isRequired('You must select a product')">
                            <option value="">Please select a product</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="stockLogChangeAmount" class="form-label">Amount</label>
                        <input type="number" class="form-control" name="Amount" id="stockLogChangeAmount"
                               placeholder="Enter change amount" data-validate="isRequired('You must enter a changeAmount')">
                    </div>
                    <div class="mb-3">
                        <label for="stockLogChangeType" class="form-label">Change Type</label>
                        <select class="form-select" name="IsReceived" id="stockLogChangeType" data-validate="isRequired('You must select a change type')">
                            <option value="true" selected>In</option>
                            <option value="false">Out</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/html" id="warehouse-detail-template">
        <td colspan="4" class="bg-light">
            <div class="w-full h-auto d-flex flex-column justify-content-start align-items-start gap-2 p-2">
                <div class="row w-100">
                    <div class="col-12 col-xl-6 border-end border-black">
                        <div class="d-flex flex-row justify-content-between align-items-center mb-2 w-100">
                            <span class="h4">Transaction Logs</span>
                            <div class="d-flex flex-row">
                            </div>
                        </div>
                        <div class="card shadow-sm rounded-4 border-0 w-100">
                            <table class="table data-table table-striped mb-0" id="transaction-logs-table-<%= warehouseId %>"
                                   data-paginator="#transaction-logs-pagination-<%= warehouseId %>">
                                <thead class="table-light">
                                <tr>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Change Amount</th>
                                    <th scope="col" class="d-none d-sm-table-cell">Transaction Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr data-row-template>
                                    <td data-content-binding="ProductId" data-binding-func="product">Product A</td>
                                    <td data-content-binding data-binding-func="changeAmount">
                                        -10000
                                    </td>
                                    <td class="d-none d-sm-table-cell" data-content-binding="CreatedOn"
                                        data-binding-func="formatDate">2025-05-21</td>
                                </tr>
                                <!-- More rows -->
                                </tbody>
                            </table>
                            <div class="card-body p-2">


                                <!-- Pagination -->
                                <nav>
                                    <ul data-pagination id="transaction-logs-pagination-<%= warehouseId %>" class="pagination rounded-2 overflow-hidden justify-content-end mb-0">
                                        <li data-active-page-template class="page-item active"><a class="page-link" href="#" data-page>1</a></li>
                                        <li data-page-template class="page-item"><a class="page-link" href="#" data-page>1</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                    </div>

                    <div class="col-12 col-xl-6">
                        <div class="d-flex flex-row justify-content-between align-items-center mb-2 w-100">
                            <span class="h4">Stock Records</span>
                            <div class="d-flex flex-row">
                                <button class="btn btn-primary me-1 create-stock-log-button">
                                    <i class="bi bi-plus-circle"></i>
                                    New Stock Change
                                </button>
                            </div>
                        </div>
                        <div class="card shadow-sm rounded-4 border-0 w-100">
                            <table class="table data-table table-striped mb-0" id="stocks-table-<%= warehouseId %>"
                                   data-paginator="#stocks-pagination-<%= warehouseId %>">
                                <thead class="table-light">
                                <tr>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Product Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr data-row-template>
                                    <td data-content-binding="ProductId" data-binding-func="product">Product A</td>
                                    <td data-content-binding="TotalStock">
                                        25666
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                            <div class="card-body p-2">


                                <!-- Pagination -->
                                <nav>
                                    <ul data-pagination id="stocks-pagination-<%= warehouseId %>" class="pagination rounded-2 overflow-hidden justify-content-end mb-0">
                                        <li data-active-page-template class="page-item active"><a class="page-link" href="#" data-page>1</a></li>
                                        <li data-page-template class="page-item"><a class="page-link" href="#" data-page>1</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </td>
</script>

<?php
$viewEngine->startCustomScripts();
?>

<script type="text/javascript">
    BindingFunctions.product = function(productId) {
        return fromDataSource('/api/products/get-dropdown', productId);
    };


    const entitiesTable = initDatatable('#entities-table', '/api/warehouses');

    initFormModal('#entity-form-modal', entitiesTable, {
        createTitle: 'Create new Warehouse',
        updateTitle: 'Update Warehouse',
    });


    addListener('[data-detail-button]', 'click', function (e) {
       const warehouseId = e.target.getAttribute('data-entity-id');

       const warehouseRow = e.target.closest('tr');

       // Delete last detail row
        const lastDetailRow = warehouseRow.parentElement.querySelector('[data-detail-row="'+warehouseId+'"]');
        if(lastDetailRow)
        {
            // Toggle off action
            lastDetailRow.remove();
            return;
        }

       // Toggle on action
        const warehouseTemplate = document.getElementById('warehouse-detail-template').innerHTML;
        const warehouseElement = oegTemplate(warehouseTemplate, {
            warehouseId: warehouseId
        });
        const row = document.createElement('tr');
        row.setAttribute('data-temp-row', true);
        row.setAttribute('data-detail-row', warehouseId);
        row.innerHTML = warehouseElement;

        warehouseRow.after(row);

        BindingFunctions.changeAmount = function(transactionLog) {

            const sign = (transactionLog.IsReceived)
                ? '+' : '-';

            return sign + transactionLog.Amount;
        };
        const transactionLogsTable = initDatatable('#transaction-logs-table-'+warehouseId, '',
            state => {
                state.datasource.list = '/api/warehouses/stock-transactions/'+warehouseId;
            });
        const stockRecordsTable = initDatatable('#stocks-table-'+warehouseId, '', state => {
            state.datasource.list = '/api/warehouses/stocks/'+warehouseId;
        });


        row.querySelector('.create-stock-log-button').addEventListener('click', function (e) {
            initFormModal('#stock-log-form-modal', stockRecordsTable, {
                createTitle: 'Create new Unknown Stock Log',
                createUrl: '/api/warehouses/create-stock-log',
                completedCallback: (response) => {
                    refreshDataTable(transactionLogsTable, false);
                }
            });

            showFormModal('#stock-log-form-modal', null, {
                IsReceived: true,
                WarehouseId: warehouseId
            });
        });
    });


</script>

<?php
$viewEngine->endCustomScripts();
?>

