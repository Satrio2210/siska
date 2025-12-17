  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAJRNL02X-AKSES.php";
    aksesku.onreadystatechange=stateChangedAkses;
    var params = "q="+fieldid;
    //alert('Parameter adalah '+fieldid);
    aksesku.open("POST",url,true);
    aksesku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    aksesku.setRequestHeader("Content-length", params.length);
    aksesku.setRequestHeader("Connection", "close");
    aksesku.send(params);

  }

  function buatajaxakses()
  {
    if (window.XMLHttpRequest)
    {
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject)
    {
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }

  function stateChangedAkses()
  {
  var data;
  if (aksesku.readyState==4)
    {

    xdata=aksesku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
            document.getElementById('tgljrnldate').setAttribute('disabled','true');

            document.getElementById('txtsale_drugs').setAttribute('disabled','true');
            document.getElementById('txtvat_out').setAttribute('disabled','true');
            document.getElementById('txtsale_bhp').setAttribute('disabled','true');
            document.getElementById('txtcash_drugs').setAttribute('disabled','true');

            document.getElementById('txtinventory_drugs').setAttribute('disabled','true');
            document.getElementById('txtinventory_bhp').setAttribute('disabled','true');
            document.getElementById('txtusage_cost').setAttribute('disabled','true');

            document.getElementById('txttret_doct').setAttribute('disabled','true');
            document.getElementById('txttret_nurs').setAttribute('disabled','true');
            document.getElementById('txttret_labs').setAttribute('disabled','true');

            document.getElementById('txtcash_tret').setAttribute('disabled','true');
            document.getElementById('txtaccount_receivable').setAttribute('disabled','true');

            document.getElementById('txtfee_admin').setAttribute('disabled','true');
            document.getElementById('txtfee_resep').setAttribute('disabled','true');

            document.getElementById('txtcash_admin').setAttribute('disabled','true');

            document.getElementById('txtsearch').focus();
      }
      else
      {
            document.getElementById('txtsearch').setAttribute('disabled','true');
            document.getElementById('tgljrnldate').setAttribute('disabled','true');

            document.getElementById('txtsale_drugs').setAttribute('disabled','true');
            document.getElementById('txtvat_out').setAttribute('disabled','true');
            document.getElementById('txtsale_bhp').setAttribute('disabled','true');
            document.getElementById('txtcash_drugs').setAttribute('disabled','true');

            document.getElementById('txtinventory_drugs').setAttribute('disabled','true');
            document.getElementById('txtinventory_bhp').setAttribute('disabled','true');
            document.getElementById('txtusage_cost').setAttribute('disabled','true');

            document.getElementById('txttret_doct').setAttribute('disabled','true');
            document.getElementById('txttret_nurs').setAttribute('disabled','true');
            document.getElementById('txttret_labs').setAttribute('disabled','true');

            document.getElementById('txtcash_tret').setAttribute('disabled','true');
            document.getElementById('txtaccount_receivable').setAttribute('disabled','true');

            document.getElementById('txtfee_admin').setAttribute('disabled','true');
            document.getElementById('txtfee_resep').setAttribute('disabled','true');

            document.getElementById('txtcash_admin').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  


	// Ambil Data Transaksi Kwitansi Pasien tabel trxasale
var jrnlku;
function ambiljrnlcode(jrnlcode)
{
  if(jrnlcode.length > 10)
  {
  document.getElementById("tbljrnl").style.visibility = "hidden";
  }
  else
  {
  jrnlku = buatajaxjrnlcode();
  var url="AUTOJRNL01C.php";
  jrnlku.onreadystatechange=stateChangedjrnlcode;
  var params = "q="+jrnlcode;
  jrnlku.open("POST",url,true);
  jrnlku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  jrnlku.setRequestHeader("Content-length", params.length);
  jrnlku.setRequestHeader("Connection", "close");
  jrnlku.send(params);
  }
} 
function buatajaxjrnlcode()
{
  if (window.XMLHttpRequest)
  {
  return new XMLHttpRequest();
  }
  if (window.ActiveXObject)
  {
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
  return null;
}

function stateChangedjrnlcode()
{
  var data;
  if (jrnlku.readyState==4 && jrnlku.status==200)
  {
  data=jrnlku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tbljrnl").innerHTML = data;
    document.getElementById("tbljrnl").style.visibility = "";
    }
    else  
    {
    document.getElementById("tbljrnl").innerHTML = "";
    document.getElementById("tbljrnl").style.visibility = "hidden";
    }
  }
}

function isijrnlcode(salecode,regicode,paiddate)
{
	try 
	{
  document.getElementById('tgljrnldate').removeAttribute('disabled','true');

  document.getElementById('txtsale_drugs').removeAttribute('disabled','true');
  document.getElementById('txtvat_out').removeAttribute('disabled','true');
  document.getElementById('txtsale_bhp').removeAttribute('disabled','true');
  document.getElementById('txtcash_drugs').removeAttribute('disabled','true');

  document.getElementById('txtinventory_drugs').removeAttribute('disabled','true');
  document.getElementById('txtinventory_bhp').removeAttribute('disabled','true');
  document.getElementById('txtusage_cost').removeAttribute('disabled','true');

  document.getElementById('txttret_doct').removeAttribute('disabled','true');
  document.getElementById('txttret_nurs').removeAttribute('disabled','true');
  document.getElementById('txttret_labs').removeAttribute('disabled','true');
  document.getElementById('txtcash_tret').removeAttribute('disabled','true');
  document.getElementById('txtaccount_receivable').removeAttribute('disabled','true');

  document.getElementById('txtfee_admin').removeAttribute('disabled','true');
  document.getElementById('txtfee_resep').removeAttribute('disabled','true');
  document.getElementById('txtcash_admin').removeAttribute('disabled','true');

  document.getElementById('tgljrnldate').value = paiddate;
  document.getElementById('hidsalecode').value = salecode;
  document.getElementById('hidregicode').value = regicode;

  ambiltrxascreen(salecode,regicode);
  viewcode(salecode,regicode);

  document.getElementById("txtsearch").value = '';
  document.getElementById("txtsearch").focus();
  document.getElementById("tbljrnl").style.visibility = "hidden";
  document.getElementById("tbljrnl").innerHTML = "";

	} catch(err){ alert(err.message); }


}



	// ambil Akun Code dari tabel coacmast
var coacku;
function ambilcoaccode(coaccode)
{
  if(coaccode.length > 4)
  {
  document.getElementById("tblcoac").style.visibility = "hidden";
  }
  else
  {
  coacku = buatajaxcoaccode();
  var url="AUTOJRNL01C-COAC.php";
  coacku.onreadystatechange=stateChangedcoaccode;
  var params = "q="+coaccode;
  coacku.open("POST",url,true);
  coacku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  coacku.setRequestHeader("Content-length", params.length);
  coacku.setRequestHeader("Connection", "close");
  coacku.send(params);
  }
} 
function buatajaxcoaccode()
{
  if (window.XMLHttpRequest)
  {
  return new XMLHttpRequest();
  }
  if (window.ActiveXObject)
  {
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
  return null;
}

function stateChangedcoaccode()
{
  var data;
  if (coacku.readyState==4 && coacku.status==200)
  {
  data=coacku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblcoac").innerHTML = data;
    document.getElementById("tblcoac").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblcoac").innerHTML = "";
    document.getElementById("tblcoac").style.visibility = "hidden";
    }
  }
}

function isicoaccode(tblcoaccode,tblcoacname,tblcoaccrnc)
{
	try 
	{
  document.getElementById("txtcoaccode").value = tblcoaccode;
  document.getElementById("txtcoacname").value = tblcoacname;
  document.getElementById("txtjrnldebt").removeAttribute('disabled','true');
  document.getElementById("txtjrnlcrdt").removeAttribute('disabled','true');
  document.getElementById("txtdiviname").removeAttribute('disabled','true');
  document.getElementById("txtjrnlnote").removeAttribute('disabled','true');
  document.getElementById("txtjrnldebt").focus();
  document.getElementById("tblcoac").style.visibility = "hidden";
  document.getElementById("tblcoac").innerHTML = "";

	} catch(err){ alert(err.message); }


}
	// ambil Kode Divisi dari tabel tbledivi
var diviku;
function ambildivicode(divicode)
{
  if(divicode.length > 5)
  {
  document.getElementById("tbldivi").style.visibility = "hidden";
  }
  else
  {
  diviku = buatajaxdivicode();
  var url="TRXAJRNL01C-DIVI.php";
  diviku.onreadystatechange=stateChangeddivicode;
  var params = "q="+divicode;
  diviku.open("POST",url,true);
  diviku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  diviku.setRequestHeader("Content-length", params.length);
  diviku.setRequestHeader("Connection", "close");
  diviku.send(params);
  }
} 
function buatajaxdivicode()
{
  if (window.XMLHttpRequest)
  {
  return new XMLHttpRequest();
  }
  if (window.ActiveXObject)
  {
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
  return null;
}

function stateChangeddivicode()
{
  var data;
  if (diviku.readyState==4 && diviku.status==200)
  {
  data=diviku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tbldivi").innerHTML = data;
    document.getElementById("tbldivi").style.visibility = "";
    }
    else  
    {
    document.getElementById("tbldivi").innerHTML = "";
    document.getElementById("tbldivi").style.visibility = "hidden";
    }
  }
}

function isidivicode(tbldivicode,tbldiviname,tbldivicrnc)
{
	try 
	{
  document.getElementById("hiddivicode").value = tbldivicode;
  document.getElementById("txtdiviname").value = tbldiviname;
  document.getElementById("txtjrnlnote").focus();
  document.getElementById("tbldivi").style.visibility = "hidden";
  document.getElementById("tbldivi").innerHTML = "";

	} 
  catch(err){ alert(err.message); }
}

// Update Data Jurnal Transaksi ke Tabel Jurnal
  var ajaxupdate;
  function Update(jrnlcode,jrnldate,oldcoaccode,coaccode,coacname,jrnldebt,jrnlcrdt,divicode,diviname,jrnlnote,entrtime)
  {
    ajaxupdate = buatajaxupdate();
    var url="TRXAJRNL02U.php";
    ajaxupdate.onreadystatechange=stateChangedUpdate;
    var params = "q="+jrnlcode+"|"+jrnldate+"|"+oldcoaccode+"|"+coaccode+"|"+coacname+"|"+jrnldebt+"|"+jrnlcrdt+"|"+divicode+"|"+diviname+"|"+jrnlnote+"|"+entrtime;
    //alert(params);
    ajaxupdate.open("POST",url,true);
    ajaxupdate.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxupdate.setRequestHeader("Content-length", params.length);
    ajaxupdate.setRequestHeader("Connection", "close");
    ajaxupdate.send(params);
  }

  function buatajaxupdate()
  {
    if (window.XMLHttpRequest)
    {
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject)
    {
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }

  function stateChangedUpdate()
  {
  var data;
  if (ajaxupdate.readyState==4)
    {
      var todaynow = new Date()
      var today = convertDate(todaynow);
      document.getElementById('txtjrnlcode').value = '';
			document.getElementById('hidentrtime').value = '';
			document.getElementById('tgljrnldate').value = today;
			document.getElementById('txtcoaccode').value = '';
      document.getElementById('hidcoaccode').value = '';
			document.getElementById('txtcoacname').value = '';
			document.getElementById('txtjrnldebt').value = '';
			document.getElementById('txtjrnlcrdt').value = '';
			document.getElementById('hiddivicode').value = '';
			document.getElementById('txtdiviname').value = '';
			document.getElementById('txtjrnlnote').value = '';
      document.getElementById('txtjrnlcode').focus();
      var kodejurnal = document.getElementById('hidjrnlcode').value;
      ambiltrxascreen(kodejurnal);
        //}
    }
  }
// Selesai Update Data Jurnal Transaksi ke Tabel Jurnal

// Insert Data Jurnal Transaksi Obat ke Tabel Jurnal
  var ajaxInsertDrugs;
  function InsertDrugs(salecode,regicode,jrnldate,saledrugs,codesaledrugs,namesaledrugs,vatout,codevatout,namevatout,salebhp,codesalebhp,namesalebhp,cashdrugs,codecashdrugs,namecashdrugs)
  {
    ajaxInsertDrugs = buatajaxInsertDrugs();
    var url="AUTOJRNL01E-DRUGS.php";
    ajaxInsertDrugs.onreadystatechange=stateChangedInsertDrugs;
    var params = "q="+salecode+"|"+regicode+"|"+jrnldate+"|"+saledrugs+"|"+codesaledrugs+"|"+namesaledrugs+"|"+vatout+"|"+codevatout+"|"+namevatout+"|"+salebhp+"|"+codesalebhp+"|"+namesalebhp+"|"+cashdrugs+"|"+codecashdrugs+"|"+namecashdrugs;
    //alert(params);
    ajaxInsertDrugs.open("POST",url,true);
    ajaxInsertDrugs.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxInsertDrugs.setRequestHeader("Content-length", params.length);
    ajaxInsertDrugs.setRequestHeader("Connection", "close");
    ajaxInsertDrugs.send(params);
  }

  function buatajaxInsertDrugs()
  {
    if (window.XMLHttpRequest)
    {
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject)
    {
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }

  function stateChangedInsertDrugs()
  {
  var data;
  if (ajaxInsertDrugs.readyState==4)
    {

            document.getElementById('txtsale_drugs').setAttribute('disabled','true');
            document.getElementById('txtvat_out').setAttribute('disabled','true');
            document.getElementById('txtsale_bhp').setAttribute('disabled','true');
            document.getElementById('txtcash_drugs').setAttribute('disabled','true');

            swal({
                    title: 'Auto Jurnal Berhasil' ,
                    text: 'Auto Jurnal Selesai di lakukan',
                    icon: 'success',
                });
    }
  }
// Selesai Insert Data Jurnal Transaksi ke Tabel Jurnal
// Insert Data Jurnal Transaksi Persediaan ke Tabel Jurnal
  var ajaxInsertInventory;
  function InsertInventory(salecode,regicode,jrnldate,inventory_drugs,codeinventory_drugs,nameinventory_drugs,inventory_bhp,codeinventory_bhp,nameinventory_bhp,usage_cost,codeusage_cost,nameusage_cost)
  {
    ajaxInsertInventory = buatajaxInsertInventory();
    var url="AUTOJRNL01E-INVENTORY.php";
    ajaxInsertInventory.onreadystatechange=stateChangedInsertInventory;
    var params = "q="+salecode+"|"+regicode+"|"+jrnldate+"|"+inventory_drugs+"|"+codeinventory_drugs+"|"+nameinventory_drugs+"|"+inventory_bhp+"|"+codeinventory_bhp+"|"+nameinventory_bhp+"|"+usage_cost+"|"+codeusage_cost+"|"+nameusage_cost;
    //alert(params);
    ajaxInsertInventory.open("POST",url,true);
    ajaxInsertInventory.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxInsertInventory.setRequestHeader("Content-length", params.length);
    ajaxInsertInventory.setRequestHeader("Connection", "close");
    ajaxInsertInventory.send(params);
  }

  function buatajaxInsertInventory()
  {
    if (window.XMLHttpRequest)
    {
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject)
    {
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }

  function stateChangedInsertInventory()
  {
  var data;
  if (ajaxInsertInventory.readyState==4)
    {

            document.getElementById('txtinventory_drugs').setAttribute('disabled','true');
            document.getElementById('txtinventory_bhp').setAttribute('disabled','true');
            document.getElementById('txtusage_cost').setAttribute('disabled','true');

            swal({
                    title: 'Auto Jurnal Berhasil' ,
                    text: 'Auto Jurnal Selesai di lakukan',
                    icon: 'success',
                });
    }
  }
// Selesai Insert Data Jurnal Transaksi Persediaan ke Tabel Jurnal

// Insert Data Jurnal Transaksi Jasa ke Tabel Jurnal
  var ajaxInsertJasa;
  function InsertJasa(salecode,regicode,jrnldate,tret_doct,codetret_doct,nametret_doct,tret_nurs,codetret_nurs,nametret_nurs,tret_labs,codetret_labs,nametret_labs,cash_tret,codecash_tret,namecash_tret,account_receivable,codeaccount_receivable,nameaccount_receivable)

  {
    ajaxInsertJasa = buatajaxInsertJasa();
    var url="AUTOJRNL01E-JASA.php";
    ajaxInsertJasa.onreadystatechange=stateChangedInsertJasa;
    var params = "q="+salecode+"|"+regicode+"|"+jrnldate+"|"+tret_doct+"|"+codetret_doct+"|"+nametret_doct+"|"+tret_nurs+"|"+codetret_nurs+"|"+nametret_nurs+"|"+tret_labs+"|"+codetret_labs+"|"+nametret_labs+"|"+cash_tret+"|"+codecash_tret+"|"+namecash_tret+"|"+account_receivable+"|"+codeaccount_receivable+"|"+nameaccount_receivable;

    //alert(params);
    ajaxInsertJasa.open("POST",url,true);
    ajaxInsertJasa.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxInsertJasa.setRequestHeader("Content-length", params.length);
    ajaxInsertJasa.setRequestHeader("Connection", "close");
    ajaxInsertJasa.send(params);
  }

  function buatajaxInsertJasa()
  {
    if (window.XMLHttpRequest)
    {
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject)
    {
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }

  function stateChangedInsertJasa()
  {
  var data;
  if (ajaxInsertJasa.readyState==4)
    {

            document.getElementById('txttret_doct').setAttribute('disabled','true');
            document.getElementById('txttret_nurs').setAttribute('disabled','true');
            document.getElementById('txttret_labs').setAttribute('disabled','true');

            document.getElementById('txtcash_tret').setAttribute('disabled','true');
            document.getElementById('txtaccount_receivable').setAttribute('disabled','true');

            swal({
                    title: 'Auto Jurnal Berhasil' ,
                    text: 'Auto Jurnal Selesai di lakukan',
                    icon: 'success',
                });
    }
  }
// Selesai Insert Data Jurnal Transaksi Jasa ke Tabel Jurnal

// Insert Data Jurnal Transaksi Admin ke Tabel Jurnal
  var ajaxInsertAdmin;
  function InsertAdmin(salecode,regicode,jrnldate,fee_admin,codefee_admin,namefee_admin,fee_resep,codefee_resep,namefee_resep,cash_admin,codecash_admin,namecash_admin)

  {
    ajaxInsertAdmin = buatajaxInsertAdmin();
    var url="AUTOJRNL01E-ADMIN.php";
    ajaxInsertAdmin.onreadystatechange=stateChangedInsertAdmin;
    var params = "q="+salecode+"|"+regicode+"|"+jrnldate+"|"+fee_admin+"|"+codefee_admin+"|"+namefee_admin+"|"+fee_resep+"|"+codefee_resep+"|"+namefee_resep+"|"+cash_admin+"|"+codecash_admin+"|"+namecash_admin;

    //alert(params);
    ajaxInsertAdmin.open("POST",url,true);
    ajaxInsertAdmin.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxInsertAdmin.setRequestHeader("Content-length", params.length);
    ajaxInsertAdmin.setRequestHeader("Connection", "close");
    ajaxInsertAdmin.send(params);
  }

  function buatajaxInsertAdmin()
  {
    if (window.XMLHttpRequest)
    {
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject)
    {
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }

  function stateChangedInsertAdmin()
  {
  var data;
  if (ajaxInsertAdmin.readyState==4)
    {

            document.getElementById('txtfee_admin').setAttribute('disabled','true');
            document.getElementById('txtfee_resep').setAttribute('disabled','true');

            document.getElementById('txtcash_admin').setAttribute('disabled','true');

            //document.getElementById('txtsearch').focus();
            swal({
                    title: 'Auto Jurnal Berhasil' ,
                    text: 'Auto Jurnal Selesai di lakukan',
                    icon: 'success',
                });
    }
  }
// Selesai Insert Data Jurnal Transaksi Admin ke Tabel Jurnal


// tampilkan data transaksi yang telah dipilih , baik setelah Update maupun setelah ditambahkan

var drz;
function ambiltrxascreen(salecode,regicode)
{
  try {	
  drz = buatajaxtrxascreen();
  var url="AUTOJRNL01V.php";
  drz.onreadystatechange=stateChangedtrxascreen;
  var params = "q="+salecode+"|"+regicode;
  drz.open("POST",url,true);
  drz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  drz.setRequestHeader("Content-length", params.length);
  drz.setRequestHeader("Connection", "close");
  drz.send(params);
  }  catch(err) {alert (err.message);}
  //}
} 

function buatajaxtrxascreen()
{
  if (window.XMLHttpRequest)
  {
  return new XMLHttpRequest();
  }
  if (window.ActiveXObject)
  {
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
  return null;
}

function stateChangedtrxascreen() 
{   var datapost;   
  if (drz.readyState==4)   
    { 
      datapost=drz.responseText;
      if(datapost.length>3)
        { 
          document.getElementById("tbltrxascreen").innerHTML = datapost;
            document.getElementById("tbltrxascreen").style.visibility = "";     
        }     
      else 
        {  
          document.getElementById("tbltrxascreen").innerHTML = "";
          document.getElementById("tbltrxascreen").style.visibility = "hidden";     
        }

    } 
}
// Tampilkan item transaksi yang telah di pilih dalam susunan jurnal pada form  
var ajaxview
function viewcode(salecode,regicode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="AUTOJRNL01C-JRNL.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+salecode+"|"+regicode;
    //alert(params);
    ajaxview.open("POST",url,true);
    ajaxview.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxview.setRequestHeader("Content-length", params.length);
    //ajaxview.setRequestHeader("Connection", "close");
    ajaxview.send(params);

  } 
  catch(err){ alert(err.message); }
}

  function buatajaxview()
  {
    if (window.XMLHttpRequest)
    {
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject)
    {
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }

  function stateChangedView()
  {
  var data;
  if (ajaxview.readyState==4)
    {
    	data=ajaxview.responseText;
      //alert(data);
    	if(data.length>3)
    	{
    	var res = data.split("|");

      // Transaksi Obat
      var nominal_sale_drugs = convertToRupiah(Math.round(res[2]));
    	document.getElementById("txtsale_drugs").value = nominal_sale_drugs;
    	document.getElementById("hidcode_sale_drugs").value = res[3];
    	document.getElementById("hidname_sale_drugs").value = res[4];

      var nominal_vat_out = convertToRupiah(Math.round(res[5]));
      document.getElementById("txtvat_out").value = nominal_vat_out;
      document.getElementById("hidcode_vat_out").value = res[6];
      document.getElementById("hidname_vat_out").value = res[7];

      var nominal_sale_bhp = convertToRupiah(Math.round(res[8]));
      document.getElementById("txtsale_bhp").value = nominal_sale_bhp;
      document.getElementById("hidcode_sale_bhp").value = res[9];
      document.getElementById("hidname_sale_bhp").value = res[10];

      var nominal_cash_drugs = convertToRupiah(Math.round(res[11]));
      document.getElementById("txtcash_drugs").value = nominal_cash_drugs;
      document.getElementById("hidcode_cash_drugs").value = res[12];
      document.getElementById("hidname_cash_drugs").value = res[13];

      // Transaksi Persediaan
      var nominal_inventory_drugs = convertToRupiah(Math.round(res[14]));
      document.getElementById("txtinventory_drugs").value = nominal_inventory_drugs;
      document.getElementById("hidcode_inventory_drugs").value = res[15];
      document.getElementById("hidname_inventory_drugs").value = res[16];

      var nominal_inventory_bhp = convertToRupiah(Math.round(res[17]));
      document.getElementById("txtinventory_bhp").value = nominal_inventory_bhp;
      document.getElementById("hidcode_inventory_bhp").value = res[18];
      document.getElementById("hidname_inventory_bhp").value = res[19];

      var nominal_usage_cost = convertToRupiah(Math.round(res[20]));
      document.getElementById("txtusage_cost").value = nominal_usage_cost;
      document.getElementById("hidcode_usage_cost").value = res[21];
      document.getElementById("hidname_usage_cost").value = res[22];

      // Transaksi Jasa
      var nominal_tret_doct = convertToRupiah(Math.round(res[23]));
      document.getElementById("txttret_doct").value = nominal_tret_doct;
      document.getElementById("hidcodetret_doct").value = res[24];
      document.getElementById("hidnametret_doct").value = res[25];

      var nominal_tret_nurs = convertToRupiah(Math.round(res[26]));
      document.getElementById("txttret_nurs").value = nominal_tret_nurs;
      document.getElementById("hidcodetret_nurs").value = res[27];
      document.getElementById("hidnametret_nurs").value = res[28];       

      var nominal_tret_labs = convertToRupiah(Math.round(res[29]));
      document.getElementById("txttret_labs").value = nominal_tret_labs;
      document.getElementById("hidcodetret_labs").value = res[30];
      document.getElementById("hidnametret_labs").value = res[31];

      var nominal_cash_tret = convertToRupiah(Math.round(res[32]));
      document.getElementById("txtcash_tret").value = nominal_cash_tret;
      document.getElementById("hidcodecash_tret").value = res[33];
      document.getElementById("hidnamecash_tret").value = res[34];

      var nominal_account_receivable = convertToRupiah(Math.round(res[35]));
      document.getElementById("txtaccount_receivable").value = nominal_account_receivable;
      document.getElementById("hidcodeaccount_receivable").value = res[36];
      document.getElementById("hidnameaccount_receivable").value = res[37];

      // Transaksi Admin
      var nominal_input_fee_admin = convertToRupiah(Math.round(res[38]));
      document.getElementById("txtfee_admin").value = nominal_input_fee_admin;
      document.getElementById("hidcodefee_admin").value = res[39];
      document.getElementById("hidnamefee_admin").value = res[40];

      var nominal_input_fee_resep = convertToRupiah(Math.round(res[41]));
      document.getElementById("txtfee_resep").value = nominal_input_fee_resep;
      document.getElementById("hidcodefee_resep").value = res[42];
      document.getElementById("hidnamefee_resep").value = res[43];

      var nominal_cash_admin = convertToRupiah(Math.round(res[44]));
      document.getElementById("txtcash_admin").value = nominal_cash_admin;
      document.getElementById("hidcodecash_admin").value = res[45];
      document.getElementById("hidnamecash_admin").value = res[46];

    	}
    	
        //}
    }
  }


// Delete Data Jurnal Transaksi ke Tabel Jurnal
  var ajaxdelete;
  function Delete(jrnlcode,coaccode,entrtime)
  {
    ajaxdelete = buatajaxdelete();
    var url="TRXAJRNL02D.php";
    ajaxdelete.onreadystatechange=stateChangedDelete;
    var params = "q="+jrnlcode+"|"+coaccode+"|"+entrtime;
    //alert(params);
    ajaxdelete.open("POST",url,true);
    ajaxdelete.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxdelete.setRequestHeader("Content-length", params.length);
    ajaxdelete.setRequestHeader("Connection", "close");
    ajaxdelete.send(params);
  }

  function buatajaxdelete()
  {
    if (window.XMLHttpRequest)
    {
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject)
    {
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }

  function stateChangedDelete()
  {
  var data;
  if (ajaxdelete.readyState==4)
    {
            var todaynow = new Date()
      var today = convertDate(todaynow);
        document.getElementById('txtjrnlcode').value = '';
        document.getElementById('hidentrtime').value = '';
        document.getElementById('tgljrnldate').value = today;
        document.getElementById('txtcoaccode').value = '';
        document.getElementById('txtcoacname').value = '';
        document.getElementById('txtjrnldebt').value = '';
        document.getElementById('txtjrnlcrdt').value = '';
        document.getElementById('hiddivicode').value = '';
        document.getElementById('txtdiviname').value = '';
        document.getElementById('txtjrnlnote').value = '';
        document.getElementById('txtjrnlcode').focus();
        var kodejurnal = document.getElementById('hidjrnlcode').value;
        ambiltrxascreen(kodejurnal);
        //}
    }
  }
// Selesai Hapus Data Jurnal Transaksi ke Tabel Jurnal
