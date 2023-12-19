<style type="text/css">
    .table-view tr td {
        line-height: auto;
        vertical-align: middle;
        padding: 5px 5px;
        margin: 0px;
    }
</style>

<div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="dataformLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalView"><i class="fas fa-angle-double-right"></i>
                    <span>แก้ไขการจอง</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-0 py-2">

                <div class="container">
                    <div class="row">
                        <div class="offset-md-0 col-md-12 offset-md-0">
                            <div class="card">
                                <div class="card-header bg-primary text-white p-2">
                                    <p class="card-title text-size-1">รายละเอียด</p> <span class="float-right editby"
                                        id="modal_vehicle_name"></span>
                                </div>
                                <form id="editForm" class="addform" name="addform" method="POST"
                                                    enctype="multipart/form-data" autocomplete="off" novalidate="">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-12 order-1 order-md-1 order-lg-1">
                                            <div class="row">
                                        
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="modal_vehicle">ยานพาหนะ</label>
                                                            <select class="form-control select2bs4" id="modal_vehicle"
                                                                name="modal_vehicle" style="width: 100%;">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="modal_date">วันที่ทำการจอง</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i
                                                                            class="far fa-clock"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control float-right"
                                                                    id="modal_date" name="modal_date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" class="form-control float-right"
                                                                    id="modal_id" name="modal_id">
                                               
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!--card-body-->
                                </form>
                            </div>
                            <!--card-->
                        </div>
                        <!--offset-md-0-->

                    </div>
                    <!--row-->
                </div>
                <!--container-->

            </div>
            <!--modal-body-->
            <div class="modal-footer justify-content-between text-right">
                <input type="button" class="btn btn-cancel btn-danger float-right" data-dismiss="modal"
                    value="ยกเลิก" />
                <input type="button" class="btn btn-save-edit btn-success float-right" value="บันทึก" />
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal-default -->
