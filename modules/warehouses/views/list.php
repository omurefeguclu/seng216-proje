<?php $viewEngine->setLayout('layout'); ?>

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
                   data-form-modal="#entity-form-modal" class="table data-table table-striped table-bordered table-hover mb-0">
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

<?php
$viewEngine->startCustomScripts();
?>

<script type="text/javascript">
    const entitiesTable = initDatatable('#entities-table', '/api/warehouses');

    initFormModal('#entity-form-modal', entitiesTable, {
        createTitle: 'Create new Warehouse',
        updateTitle: 'Update Warehouse',
    });

</script>

<?php
$viewEngine->endCustomScripts();
?>

