<!-- Header with search -->
<div class="bg-primary text-white d-flex justify-content-between align-items-center p-4">

    <h4 class="mb-0">Warehouses</h4>
    <div class="d-flex justify-content-center align-items-center gap-2">
        <input class="form-control" style="min-width: 160px;" type="search" placeholder="Search Warehouses...">
        <button class="btn btn-secondary bg-secondary" style="min-width: 140px;" data-bs-toggle="modal" data-bs-target="#createWarehouseModal">
            <i class="bi bi-plus-circle me-1"></i>
            New Warehouse
        </button>
    </div>
</div>

<!-- Table with accordion rows and buttons -->
<div class="p-3">

    <div class="card shadow-sm rounded-4 border-0">
        <div class="table-responsive">
            <table data-paginator="#vehicles-pagination" data-datatable="/api/vehicles" class="table data-table table-striped table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Plate Number</th>
                        <th scope="col" class="d-none d-sm-table-cell">Last Updated</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <tr data-row-template>
                    <td data-content-binding="Id">1</td>
                    <td data-content-binding="PlateNumber">Widget A</td>
                    <td data-content-binding="CreatedOn" data-binding-func="formatDate" class="d-none d-sm-table-cell">2025-05-21</td>
                    <td>
                        <button data-edit-button data-attr-binding-target="data-edit-button" data-attr-binding="Id"
                                class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></button>
                        <button data-delete-button data-attr-binding-target="data-delete-button" data-attr-binding="Id"
                                class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="card-body p-2">


            <!-- Pagination -->
            <nav>
                <ul id="vehicles-pagination" class="pagination justify-content-end mb-0">
                    <li data-active-page-template class="page-item active"><a class="page-link" href="#" data-page>1</a></li>
                    <li data-page-template class="page-item"><a class="page-link" href="#" data-page>1</a></li>
                </ul>
            </nav>
        </div>
    </div>


</div>


<script type="text/javascript">

</script>

