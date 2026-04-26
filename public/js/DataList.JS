// Branch Name List Search
function BranchList() {
    var BranchName = $('#BranchName').val();
    // alert(BranchName);
    $.ajax({
        url: "DataList.php",
        method: "POST",
        data: {
            BranchName: BranchName
        },
        dataType: "json",
        success: function (data) {
            // alert(data);
            $('#BranchList').empty();
            for (var i = 0; i < data.length; i++) {
                $('#BranchList').append('<option value="' + data[i] + '">' + data[i] + '</option>');
            }
        }
    })
}

