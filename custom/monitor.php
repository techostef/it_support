<!-- <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->

<link rel="stylesheet" type="text/css" href="custom/assets/datatables/v1.10.18/css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="custom/assets/datatables/v1.10.18/css/datatables.jqueryui.min.css">
<!-- <link rel="stylesheet" type="text/css" href="assets/datatables/datatables.min.css"> -->
<!-- <script type="text/javascript" src="assets/datatables/datatables.min.js"></script> -->

<script type="text/javascript" src="custom/assets/datatables/v1.10.18/js/jquery.datatables.min.js"></script>
<script type="text/javascript" src="custom/assets/datatables/v1.10.18/js/datatables.jqueryui.min.js"></script>


<table id="datatables" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Alias</th>
            <th>Lokasi</th>
            <th>Uptime</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody id="tbodyContent">
        
    </tbody>
</table>

<script>
$(document).ready(function() {
	var content = '',a='';
    $('#datatables').DataTable({
		"paging":   false,
        "ordering": false,
        "info":     false,
		"searching": false,
	});
	setInterval(function(){
		$.ajax({
			type:"GET",
			url:"custom/getcontent.php",
			success:function(data){
				try{
					data = jQuery.parseJSON(data);
					content = "";
					$("#tbodyContent").html("");
					$.each(data,function(i,item){
						a='';
						if(item['status']=="DOWN"){
							a='background:#b95959';
						}
						content += "<tr style='"+a+"'>";
						content += "<td>";
						content += item['alias'];
						content += "</td>";
						content += "<td>";
						content += item['location'];
						content += "</td>";
						content += "<td>";
						content += item['uptime'];
						content += "</td>";
						content += "<td>";
						content += item['status'];
						content += "</td>";
						content += "</tr>";
					});
					$("#tbodyContent").append(content);
				}catch(err){
					console.log(err);
					content = "";
					$("#tbodyContent").html("");
					content += "<tr>";
					content += "<td colspan='4' style='text-align:center'>";
					content += 'Server Down';
					content += "</td>";
					content += "</tr>";
					$("#tbodyContent").append(content);
					//alert("Tidak dapat terkoneksi dengan server");
				}
			}
		})
	},1000);
} );

</script>