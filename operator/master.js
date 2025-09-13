function bersihkan(){
	$("#lblhalaman").val("");
	$("#txttransid").val(""); $("#txttransketerangan").val("");

	$("#cbokelamin").val('').trigger('change');
	$("#cboumur").val('').trigger('change');

	$("#cbolapdiagnosa").val('').trigger('change');
	$("#cbokategorigawat").val('').trigger('change');

	$("#cbolapUGD").val('').trigger('change');
}

function bersihkanHalaman(){
	$("#area-tabel-layanan").css("display","none");
	
	$("#area-tabel-ambulan").css("display","none");
	$("#divtabellapambulan").css("display","none");
	$("#divtabeldetaillapambulan").css("display","none");
	
	$("#txttransmenu").val("");
}
