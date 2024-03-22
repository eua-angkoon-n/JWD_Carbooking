<div class="modal fade" id="modal-viewMiles" tabindex="-1" role="dialog" aria-labelledby="dataformLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalView"><i class="fas fa-angle-double-right"></i>
                    <span>แก้ไขเลขไมล์</span></h5>
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
                                                            <label for="modal_vehicle">เลขไมล์ขาออก</label>
                                                            <div class="form-group">
                                                                <input type="number" min="0" id="mileOut" name="mileOut" placeholder="ไมล์ขาออก..." class="form-control"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="modal_vehicle">เลขไมล์ขาเข้า</label>
                                                            <div class="form-group">
                                                                <input type="number" min="0" id="mileIn" name="mileIn" placeholder="ไมล์ขาเข้า..." class="form-control"/>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" class="form-control float-right" id="mile_id" name="mile_id">
                                                    <input type="hidden" class="form-control float-right" id="id_vehicle" name="id_vehicle">
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
                <input type="button" class="btn btn-edit-mile btn-success float-right" data-id="" value="บันทึก" />
            </div>
        </div>
    </div>
</div>