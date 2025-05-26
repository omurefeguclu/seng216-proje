<div class="card shadow-sm rounded-4 border-0">
    <div class="table-responsive">
        <table id="stock-transactions-table" data-paginator="#stock-transactions-pagination"
               data-form-modal="#stock-transaction-form-modal" class="table data-table table-striped table-bordered table-hover mb-0">
            <thead class="table-light">
            <tr>
                <th scope="col">Vehicle</th>
                <th scope="col">From</th>
                <th scope="col">To</th>
                <th scope="col">Product</th>
                <th scope="col">Amount</th>
                <th scope="col" class="d-none d-md-table-cell">Last Updated</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr data-row-template>
                <td data-content-binding="VehicleId" data-binding-func="vehicle">1</td>
                <td data-content-binding="FromWarehouseId" data-binding-func="warehouse">1</td>
                <td data-content-binding="ToWarehouseId" data-binding-func="warehouse">1</td>
                <td data-content-binding="ProductId" data-binding-func="product">1</td>
                <td data-content-binding="Amount">1</td>
                <td data-content-binding="CreatedOn" data-binding-func="formatDate" class="d-none d-md-table-cell">2025-05-21</td>
                <td>
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
            <ul data-pagination id="stock-transactions-pagination" class="pagination rounded-2 overflow-hidden justify-content-end mb-0">
                <li data-active-page-template class="page-item active"><a class="page-link" href="#" data-page>1</a></li>
                <li data-page-template class="page-item"><a class="page-link" href="#" data-page>1</a></li>
            </ul>
        </nav>
    </div>
</div>

<div class="modal fade" id="stock-transaction-form-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Create Stock Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="alert alert-danger d-flex align-items-center d-none" data-error="div" role="alert">
                        <svg class="bi flex-shrink-0 me-2" role="img"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                            An example danger alert with an icon
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="vehicleSelect" class="form-label">Associated Vehicle</label>
                        <select class="form-select" name="VehicleId" id="vehicleSelect" data-datasource="/api/vehicles/get-dropdown"
                                data-validate="isRequired('You must select a vehicle')">
                            <option value="">Please select a vehicle</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="productSelect" class="form-label">Product</label>
                        <select class="form-select" name="ProductId" id="productSelect" data-datasource="/api/products/get-dropdown"
                        data-validate="isRequired('You must select a product')">
                            <option value="">Please select a product</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amountInput" class="form-label">Amount</label>
                        <input class="form-control" type="number" name="Amount" placeholder="Enter the transaction amount"
                                data-validate="isRequired('You must pick an amount')" />
                    </div>
                    <div class="mb-3">
                        <label for="fromWarehouseSelect" class="form-label">From Warehouse</label>
                        <select class="form-select" name="FromWarehouseId" id="fromWarehouseSelect" data-datasource="/api/warehouses/get-dropdown"
                                data-validate="isRequired('You must select a warehouse')">
                            <option value="">Please select a warehouse</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="toWarehouseSelect" class="form-label">To Warehouse</label>
                        <select class="form-select" name="ToWarehouseId" id="toWarehouseSelect" data-datasource="/api/warehouses/get-dropdown"
                                data-validate="isRequired('You must select a warehouse')">
                            <option value="">Please select a warehouse</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-success">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $viewEngine->startCustomScripts(); ?>
<script type="text/javascript">
    BindingFunctions.vehicle = function(vehicleId) {
        return fromDataSource('/api/vehicles/get-dropdown', vehicleId);
    };
    BindingFunctions.product = function(productId) {
        return fromDataSource('/api/products/get-dropdown', productId);
    };
    BindingFunctions.warehouse = function(warehouseId) {
        return fromDataSource('/api/warehouses/get-dropdown', warehouseId);
    };
</script>
<?php $viewEngine->endCustomScripts(); ?>