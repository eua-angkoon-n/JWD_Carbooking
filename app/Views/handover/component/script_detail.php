<script>
$(document).ready(function () {

    // setupImagePreviews();
    $(".btn-expense-remove").hide();

    $('.btn-expense-add').click(function () {
        var newExpenseRow = `
        <div class="row expense-row expense-group">
            <div class="col-sm-12 col-md-2">
                <div class="form-group">
                    <select class="form-control select2bs4" id="expense" name="expense" style="width: 100%;">
                        <?php echo $Expense;?> 
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="form-group">
                        <input type="number" min="0" id="expenseAmount" name="expenseAmount" placeholder="จำนวน...(บาท)" class="form-control"/>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 order-4 order-md-3">
                <div class="form-group">
                    <div class="row-fluid">
                        <div class="col-md-12">
                            <input type="file" name="expenseFile[]" id="expenseFile"
                                class="border p-1 w-100" multiple
                                accept="image/*"
                                aria-describedby="inputGroupPrepend">
                            <div id="expressErrMsg" class="text-danger">
                            </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>`;
        // Append the new row to the form or a specific div
        $(".div-expense").append(newExpenseRow);
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        updateRemoveButtonVisibility()
    });

    $('.btn-expense-remove').click(function () {
        // ลบ row ล่าสุดของค่าใช้จ่าย
        $(".div-expense .expense-row").last().remove();
        updateRemoveButtonVisibility()
    });
});

function updateRemoveButtonVisibility() {
        if ($(".expense-row").length > 0) {
            $(".btn-expense-remove").show();
        } else {
            $(".btn-expense-remove").hide();
        }
}

// function setupImagePreviews() {
//     document.querySelectorAll('.expense-file-input').forEach(input => {
//     input.addEventListener('change', function(e) {
//         const previewId = e.target.getAttribute('data-preview');
//         const preview = document.getElementById(previewId);
//         preview.innerHTML = ''; // ล้างพรีวิวเดิม

//         const files = e.target.files;
//         for (let i = 0; i < files.length; i++) {
//             const file = files[i];
//             const reader = new FileReader();
//             reader.onload = function(event) {
//                 const img = document.createElement('img');
//                 img.classList.add('col-md-3', 'img-thumbnail');
//                 img.src = event.target.result;
//                 img.style.maxWidth = '100%';
//                 preview.appendChild(img);
//             };
//             reader.readAsDataURL(file);
//         }
//     });
// });
// }


</script>