	<?php
	 include_once("header.php");		 
	?>

	<input type="hidden" value="" id="report_name" >
	<input type="hidden" value="" id="process">	

	<input type="hidden" value="Bahera" id="plant">
	<input type="hidden" value="" id="d_m_y_text">
	<input type="hidden" value="" id="day_m_y">
	<input type="hidden" value="" id="d_month_y">
	<input type="hidden" value="" id="d_m_year"> 
	
	
	<input type="hidden" value="" id="report_name1" >
	
	<input type="hidden" id="type_value">
	<input type="hidden" id="fromdate">	
	<input type="hidden" id="todate">
	<input type="hidden" id="report_names">
	<input type="hidden" id="file_name"> 
	<input type="hidden" id="excel_File_name"> 
	<input type="hidden" id="inverter_report_data"> 
	<input type="hidden" id="inverter_report_graph"> 
	
	
	<input type="hidden" id="block_report_data"> 
	<input type="hidden" id="block_report_graph"> 
	<input type="hidden" id="block_select">
	<input type="hidden" id="time_now">
	
	


	

			<aside class="right-side">   



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Scheduled Report Download</h4>
      </div>
      <div class="modal-body">
	  	<input class="form-control" id="datetimepicker_zip" type="text" placeholder="Select Date" title="Select Date"> <br><br>
    <input type="button" id="download" value="Download" class="btn btn-primary">     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>       
      </div>
    </div>

  </div>
</div>
	





				<section class="content" style="min-height:600px;">

					<div class="row">
							<div class="col-md-12 lg-12">
							

<table style="width:100%; display:none;" border="0" id="load" ><tr style="text-align: center;">
<td align="middle"> 
<table style="vertical-align: middle;"> <tr><td style="vertical-align: middle; padding-right: 20px;">
					Loading 
</td>   <td align="middle" style="padding-right: 20px;">					
<img style="overflow: hidden; display:block; margin:auto;"  src='<?php echo base_url()."image/plot.gif"; ?>'>
</td><td  style="vertical-align: middle;">
 Please wait..										
 </td>
 </tr>
 </table>

</td> </tr> </table>														
							

                            <div class="box" id="table_data_div" style="display:none;">																	
                                <div class="box-body">		
				<div id="table_data"></div>					 
								</div>
							</div>

					
					
<table border="0" style="vertical-align: middle;" width="100%" style="background-color:#D3D3D3; display:none;" id="dmy_mtt"> <tr>
<td style="vertical-align: middle; display:none;" align="left" width="50%" id="day_only">
		<button style="display:none;" type="button" id="hour_btn" class="btn btn-default" onfocus="if(this.blur)this.blur()">Hourly</button>
	  <button type="button" id="date_btn" class="btn btn-default" onfocus="if(this.blur)this.blur()">Day</button>
	  <button type="button" id="month_btn" class="btn btn-default" onfocus="if(this.blur)this.blur()">Month</button>
	  <button type="button" id="year_btn" class="btn btn-default" onfocus="if(this.blur)this.blur()">Year</button>
	  <button type="button" id="till_btn" class="btn btn-default" onfocus="if(this.blur)this.blur()">Till Date</button>

</td>

<!--<td style="vertical-align: middle; display:none;" align="right" width="50%" id="plant_only">
	  <button type="button" id="plant1_btn" class="btn btn-default" onfocus="if(this.blur)this.blur()">Plant1</button>
	  <button type="button" id="plant2_btn" class="btn btn-default" onfocus="if(this.blur)this.blur()">Plant2</button>
	  <button type="button" id="all_btn" class="btn btn-default" onfocus="if(this.blur)this.blur()">Plant Both</button>
</td>-->
<td style="vertical-align: middle; display:none;" align="right" width="50%" id="plant_only">
	  <div id="plant1_btn"></div>
      <div id="plant2_btn" ></div>
	  <div id="all_btn"></div>
</td>

</tr>

</table>					
					
<table border="0" style="vertical-align: middle;" width="100%" id="export_option"> <tr>

<td style="vertical-align: middle;" align="right" width="75%">
<div id="blcok_sel" style="display:none;">Select Block
<form id="form1">
<!--Lomada change number of blocks-->
<select id="blcok_sel" onchange="GetSelectedTextValue(this)" data-default-value="B01">
<option selected="selected" value="B01">B01</option> 
<option value="B02">B02</option> 
<option value="B03">B03</option> 
<option value="B04">B04</option> 
</select>

</form>

</div>

<div id="block_sel2" style="display:none;">Select Block
<form id="form2">
<select id="block_sel_select" data-default-value="all" style="display:none;">
<option selected="selected" value="All">All</option>  <option selected="selected" value="B01">B01</option> 
<option value="B02">B02</option> 
<option value="B03">B03</option> 
<option value="B04">B04</option> 
</select>
</form>

</div>


</td>

<td style="vertical-align: middle;" align="center" width="4%" id="excel_icon" title="Excel Download">
<img onclick="location.href='/report/test1/'+document.getElementById('block_select').value+'/'+document.getElementById('file_name').value+'.xlsx';" src="<?php echo base_url().'image/excel.ico';?>">
						
</td>
<td style="vertical-align: middle; align:right;" align="center" width="3%" id="pdf_icon" title="PDF Download">
							
						<img onclick="location.href='/report/test2/'+document.getElementById('block_select').value+'/'+document.getElementById('file_name').value+'.pdf';" src="<?php echo base_url().'image/pdf.ico';?>">
</td>
<td style="vertical-align: middle; align:right;" align="right" width="5%" title="Welspun">						
						<img  src="<?php echo base_url().'image/welspun.jpg';?>">
						
</td>
</tr></table>						

                            <div class="box">										
							
                         <div class="box-body">
				
<div style='overflow: auto; overflow-y: hidden; width:100%;'>
	<div id="excel_hide" style="width:100%;" >
		<pre class="report-pre" id="report-pre">
 
 </pre>	  
	  	 </div> 	
		 </div>
		 

								</div>
							</div>
							
					
							
							</div>
							
				
							
					</div>
					

				</section>
				



			</aside>


	<?php 
	include_once("footer.php");
	?>
