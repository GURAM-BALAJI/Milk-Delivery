<!-- Add -->

<!-- edit_liters -->
<div class="modal fade" id="edit_amount">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>ADD LITERS...</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="customer_amount.php">
                    <input type="hidden" class="c_id" name="id">
                    <div class="text-center">
                        <div class="form-group">
                            <label for="name" class=" bold col-sm-5 control-label">Name :</label>
                            <div class="col-sm-4">
                                <h5 class="name"></h5>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="amount" class=" bold col-sm-5 control-label">Present Liters : </label>
                            <div class="col-sm-4">
                                <h5 class="c_amount"></h5>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="add_amount" class=" bold col-sm-5 control-label">Add Liters : </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="add_amount" required>
                            </div>
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-success btn-flat" name="add"><i class="fa fa-check"></i> ADD LITERS</button>
                </form>
            </div>
        </div>
    </div>
</div>