<style type="text/css">
    .table-view tr td{ line-height:auto; vertical-align:middle; padding:5px 5px; margin:0px;}
</style>

<div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="dataformLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalView"><i class="fas fa-angle-double-right"></i> <span>อุปกรณ์เสริม</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body p-0 py-2">

        <div class="container">
            <div class="row">           
            <div class="offset-md-0 col-md-12 offset-md-0">  
                <div class="card">  
                    <div class="card-header bg-primary text-white p-2"><p class="card-title text-size-1">รายละเอียด</p> <span class="float-right editby"></span></div>
                    <div class="card-body p-3"> 
                    <table class="table-view table table-borderless table-responsive p-0 m-0">
                        <tr>
                            <td class="text-bold p-0 m-0 text-right" >
                                สถานะการใช้งาน:
                            </td>
                            <td id="acc_status_tb">
                                
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bold p-0 m-0 text-right" >
                                อุปกรณ์เสริม:
                            </td>
                            <td id="acc_name_tb">
                          
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bold p-0 m-0 text-right" >
                                วันที่เพิ่มเข้าระบบ:
                            </td>
                            <td id="date_created_tb">
                                
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bold p-0 m-0 text-right" >
                                วันที่แก้ไขข้อมูลล่าสุด:
                            </td>
                            <td  id="date_edited_tb">
                                
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bold p-0 m-0 text-right" >
                                หมายเหตุ:
                            </td>
                            <td id="remark_tb">
                                
                            </td>
                        </tr>
                    </table>
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--offset-md-0-->

            </div><!--row-->
        </div><!--container-->

    </div><!--modal-body-->
    <div class="modal-footer justify-content-between text-right">
        <input type="button" class="btn btn-cancel btn-danger float-right" data-dismiss="modal" value="ปิด" />
    </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal-default -->

