
          <div class="pure-control-group">

            <label for="txtsearch">Cari Pasien :</label>
                <input type="text" 
                  name="txtsearch" 
                  id="txtsearch" 
                  maxlength ="50"
                  style="width: 200px;"
                  onkeyup="if (value.length > 0) 
                  {
                    ambilpaticode(this.value);
                  } 
                  else 
                  { 
                    document.getElementById('tblpati').style.visibility = 'hidden';
                  }">

                <input type="hidden" name="hidpaticode" id="hidpaticode">

            <label for="tglregidate">Tanggal Berobat :</label>
              <input type="date" name="tglregidate" id="tglregidate" value="<?php echo $datenow; ?>">

          </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="txtmainname">Nama Pasien :</label>
                <input type="text" 
                  name="txtmainname" 
                  id="txtmainname" 
                  maxlength ="50"
                  style="width: 300px;"
                  readonly="true"> 

            <label for="txtmastcode">Rekam Medis :</label>
                <input type="text" 
                  name="txtmastcode" 
                  id="txtmastcode" 
                  maxlength ="10"
                  style="width: 120px;"
                  readonly="true"> 

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtmainbirt">Tanggal Lahir :</label>
                <input type="text" 
                  name="txtmainbirt" 
                  id="txtmainbirt" 
                  maxlength ="50"
                  style="width: 200px;"
                  readonly="true"> 


            <label for="txtmaingend">L/P :</label>
                <input type="text" 
                  name="txtmaingend" 
                  id="txtmaingend" 
                  maxlength ="50"
                  style="width: 100px;"
                  readonly="true"> 

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtmainblod">Gol. Darah :</label>
                <input type="text" 
                  name="txtmainblod" 
                  id="txtmainblod" 
                  maxlength ="4"
                  style="width: 50px;"
                  readonly="true"> 

            <label for="txtmainphne">Kontak :</label>
                <input type="text" 
                  name="txtmainphne" 
                  id="txtmainphne" 
                  maxlength ="18"
                  style="width: 200px;"
                  readonly="true"> 

          </div><!-- pure-control-group -->

          <div class="pure-control-group">


            <label for="txtmainaddr">Alamat :</label>
                <input type="text" 
                  name="txtmainaddr" 
                  id="txtmainaddr" 
                  maxlength ="100"
                  style="width: 500px;"
                  readonly="true"> 

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

          <label for="optregifrom">Datang Dari :</label>
              <select name="optregifrom" id="optregifrom" onchange="document.getElementById('optregipaym').focus();">
                <option value="A">Datang Sendiri</option>
                <option value="R">Rujukan Bidan</option>
                <option value="P">Kecelakaan</option>
              </select>

          <label for="optregipaym">Pembayaran :</label>
              <select name="optregipaym" id="optregipaym" onchange="document.getElementById('txtregidoct').focus();">
                <option value="U">Umum</option>
                <option value="B">BPJS</option>
                <option value="A">Asuransi</option>
                <option value="P">Perusahaan</option>
              </select>

          </div><!-- pure-control-group -->


          <div class="pure-control-group">

            <label for="txtregidoct">Dokter/Bidan :</label>
              <input type="text" 
                  name="txtregidoct" 
                  id="txtregidoct" 
                  maxlength ="50"
                  style="width: 250px;"
                  onkeyup="if (value.length > 0) 
                  {
                    ambildoctuser(this.value);
                  } 
                  else 
                  { 
                    document.getElementById('tbluser').style.visibility = 'hidden';
                  }">

                  <input type="hidden" name="hidregidoct" id="hidregidoct">

            <label for="txtregipoli">Poli :</label>
              <input type="text" 
                  name="txtregipoli" 
                  id="txtregipoli" 
                  maxlength ="50"
                  style="width: 200px;"
                  readonly="true"> 

                  <input type="hidden" name="hidregipoli" id="hidregipoli">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">
            <label for="hidregifee">Biaya Admin :</label>

          <input type="checkbox"
              name="optcharge" 
              id="optcharge"
              value="true"
              onclick="if (checked == true) 
                    {
                        document.getElementById('optnocharge').checked = false;

                        document.getElementById('hidregifee').value = 'Y';

                    }                
                  ">
              Ya.

          <input type="checkbox"
              name="optnocharge" 
              id="optnocharge"
              value="true"
              onclick="if (checked == true) 
                    {
                        document.getElementById('optcharge').checked = false;

                        document.getElementById('hidregifee').value = 'N';

                    }                
                  ">
              Tidak.

          <input name="hidregifee"
                id="hidregifee"
                type="hidden">

          </div><!-- pure-control-group -->
