@extends('_layouts.default')

@section('main')
<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Pelunasan Pembayaran PSB</h3>
            <div class="pull-right" style="padding-right: 10px;">

            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content">    
            <div class="alert alert-success">
                <table class="table table-form">
                    <tbody>
                        <tr>
<!--                            <td>Tahun Pelajaran</td>
                            <td>:</td>
                            <td>{{ Form::select('tapel',$selectTapel,null,array('class'=>'input-medium')) }}</td>
                            <td></td>-->
                            <td>No. Reg.</td>
                            <td>:</td>
                            <td>{{ Form::text('regid',null,array('class'=>'input-medium','placeholder'=>'Nomor Registrasi')) }}</td>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ Form::text('nama',null,array('class'=>'input-xlarge','placeholder'=>'Nama')) }}</td>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>{{ Form::text('tgl',date('d-m-Y'),array('class'=>'input-small datepicker','placeholder'=>'Nama')) }}</td>
                            <td>&nbsp;</td>
                            <td><a class="btn btn-success" id="btn-tampil">Tampilkan</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->


<div class="span8" id="widget-status">      		
    <div class="widget ">
        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Status Pembayaran</h3>
        </div> <!-- /widget-header -->
        <div class="widget-content" >

        </div>
    </div>
</div>

<div class="span4" id="widget-histori">      		
    <div class="widget ">
        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Histori Pembayaran</h3>
        </div> <!-- /widget-header -->
        <div class="widget-content" >

        </div>
    </div>
</div>

<div class="span12" id="widget-pelunasan">      		
    <div class="widget ">
        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Pembayaran/Pelunasan</h3>
        </div> <!-- /widget-header -->
        <div class="widget-content" >

        </div>
    </div>
</div>

<div id="applet-tag"></div>

<!-- Modal -->
<div id="modal-search-calon" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Pencarian Data Calon Siswa</h3>
    </div>
    <div class="modal-body">

    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
    </div>
</div>

<!--modal-->
<div id="modal-lunasi" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Pelunasan Pembayaran PSB</h3>
    </div>
    <div class="modal-body">

    </div>
    <div class="modal-footer">
        <button class="btn btn-primary">Simpan</button>
        <button class="btn btn-success">Simpan & Cetak Nota</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>

    </div>
</div>
<div id="post-rest"></div>

@stop

@section('custom-script')
<script type="text/javascript">
    jQuery(document).ready(function() {

        //set focus on load
        jQuery('input[name=regid]').focus();

        //reset ke posisi nol select tapel
        jQuery('select[name=tapel]').val([]);

        //hide widget
        jQuery('#widget-histori').hide();
        jQuery('#widget-status').hide();
        jQuery('#widget-pelunasan').hide();

        /**
         * Search data calon siswa dengan REGID
         */
        jQuery('input[name=regid]').change(function() {
            setCalonToInput();
        });

        function setCalonToInput() {
            var regid = jQuery('input[name=regid]').val();
            var calon = searchByRegid(regid);

            //clear input
            jQuery('input[name=nama]').val('');

            if (calon) {
                //tampilkan ke form
                jQuery('input[name=regid]').val(calon.regnum);
                jQuery('input[name=nama]').val(calon.nama);
                //hide tabel status dan histori
                jQuery('#widget-histori').hide();
                jQuery('#widget-status').hide();
                jQuery('#widget-pelunasan').hide();
            } else {
                alert('Data Calon Siswa tidak ditemukan, periksa kembali nomor registrasi.');
                //clear
                jQuery('input[name=regid]').val('');
                jQuery('input[name=nama]').val('');
                //focus
                jQuery('input[name=regid]').focus();
            }
        }

        function searchByRegid(regid) {
            var getCalonUrl = "{{ URL::to('transaksi/pelunasan/getcalonbyregid') }}" + "/" + regid;
            var rData = null;
            jQuery.ajax({
                url: getCalonUrl,
                dataType: "json",
                async: false,
                success: function(data) {
                    rData = data;
                }
            });

            return rData;
        }
        ;

        /**
         * cari data calon siswa dengan nama
         */
        jQuery('input[name=nama]').focus(function(data) {
            //get data calon siswa
            var getCalonUrl = "{{ URL::to('transaksi/pelunasan/getcalons') }}";
            jQuery('#modal-search-calon .modal-body').html('<div class="loader" ></div>').load(getCalonUrl);
            jQuery('#modal-search-calon').modal('show');
        });

        /**
         * Tombol pilih siswa diclick
         */
        jQuery(document).on('click', '.btn-pilih', function(data) {
            var regnum = jQuery(this).attr('regnum');
            //set to input
            jQuery('input[name=regid]').attr('value', regnum);
            setCalonToInput();
        })


        /**
         * tombol tampil di klik
         **/
        jQuery('#btn-tampil').click(function() {
            //reset widget dulu
            resetWidget();
            //
            var regid = jQuery('input[name=regid]').val();
            var nama = jQuery('input[name=nama]').val();

            if (regid == null || regid == '' || nama == null || nama == '') {
                alert('Lengkapi data yang kosong.');
            } else {
                //tampilkan status bayar
                //var getStatusUrl = "{{ URL::to('transaksi/pelunasan/getstatusbayar') }}" +"/"+tapelid+"/"+regid;
                var getStatusUrl = "{{ URL::to('transaksi/pelunasan/getstatusbayar') }}" + "/" + regid;
                jQuery('#widget-status .widget .widget-content').html('<div class="loader"></div>').load(getStatusUrl);
                //tampilkan histori pembayaran
                var getPembayaranUrl = "{{ URL::to('transaksi/pelunasan/getdatapembayaran') }}" + "/" + regid;
                jQuery('#widget-histori .widget .widget-content').html('<div class="loader"></div>').load(getPembayaranUrl);

                //tampilkan widget yang hidden

                jQuery('#widget-histori').fadeIn();
                jQuery('#widget-status').fadeIn();
            }
        });
        /**
         * Reset/sembunyikan semua widget
         */
        function resetWidget() {
            jQuery('#widget-histori').hide();
            jQuery('#widget-status').hide();
            jQuery('#widget-pelunasan').hide();
        }

        /**
         * Lunasi Sekarang
         */
        jQuery(document).on('click', '.btn-lunasi', function(data) {
            var regnum = jQuery('input[name=regid]').val();
            var getPelunasanUrl = "{{ URL::to('transaksi/pelunasan/lunasi') }}" + "/" + regnum;
//            jQuery('#modal-lunasi .modal-body').html('<div class="loader" ></div>').load(getPelunasanUrl);
//            jQuery('#modal-lunasi').modal('show');
            jQuery('#widget-pelunasan .widget-content').load(getPelunasanUrl, null, function(data) {
                //sembunyikan widget yan lain
                jQuery('#widget-histori').hide();
                jQuery('#widget-status').hide();
                //tampilkan widget pelunasan
                jQuery('#widget-pelunasan').fadeIn();
                //$.scrollTo( '#widget-pelunasan');
            });

        });

        /**
         * Tutup widget lunasi click tombol batal lunas
         */
        jQuery(document).on('click', '.btn-batal-lunasi', function() {
            jQuery('#widget-pelunasan').hide();
            //open widget status dan histori
            jQuery('#widget-histori').fadeIn();
            jQuery('#widget-status').fadeIn();
        });

        /**
         * cek apakah bisa disimpan atau tidak
         * @returns {undefined}
         */
        function bolehsimpan() {
            var ceked = 0;
            jQuery('input[type=checkbox][name=ckbayar[]]').each(function() {
                if (jQuery(this).attr('checked') == 'checked') {
                    ceked += 1;
                }
            });

            if (ceked > 0) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Simpan data ke database
         */
        jQuery(document).on('click', '.btn-simpan-lunasi', function() {
//            simpan data ke database
            if (bolehsimpan()) {
                if (saveToDB()) {
                    alert('Data telah disimpan');
                    location.reload();
                } else {
                    alert('Simpan data gagal, periksa kembali.');
                }
                ;
            } else {
                alert('Tidak ada data yang disimpan');
            }

        });


        /**
         * Simpan & Cetak
         */
        jQuery(document).on('click', '.btn-simpan-cetak-lunasi', function() {
            if (bolehsimpan()) {
                //persiapkan applet
                //menggunakan qzprint
                //var appletTag = '<applet id="qz" archive="{{ URL::to('jar/qz-print.jar') }} " name="QZPrint" code="qz.PrintApplet.class" width="50" height="50"><param name="jnlp_href" value="{{ URL::to('jar/qz-print_jnlp.jnlp') }}"><param name="cache_option" value="plugin"><param name="disable_logging" value="false"><param name="initial_focus" value="false"></applet>';
                //menggunakan jzebra
                var appletTag = '<applet name="QZPrint" code="jzebra.PrintApplet.class" archive="{{ URL::to('jar/jzebra.jar') }}" width="50px" height="50px">'
                //jQuery('body').after(appletTag);
                jQuery('#applet-tag').html(appletTag);
                if (saveToDB()) {
                    var cetakUrl = "{{ URL::to('transaksi/pelunasan/getnota') }}";
                    var notaText;
                    $.ajax({
                        type: "POST",
                        url: cetakUrl,
                        data: {
                            'datareg': JSON.stringify(dataReg),
                            'databayar': JSON.stringify(dataBayar)
                        },
                        success: function(data) {
                            notaText = data;
                            //alert(notaText);
                            QZPrint.findPrinter("{{ $appset->printeraddr }}");
                            QZPrint.append(notaText);
                            QZPrint.print();
                            alert('Data telah disimpan.\nCetak nota sedang diproses.');
                            location.reload();
                        },
                        dataType: 'text'
                    });
                } else {
                    alert('Simpan data gagal, periksa kembali.');
                }
            } else {
                alert('Tidak ada data yang disimpan');
            }
        });

        /**
         * Fungsi simpan ke database
         */
        var dataReg;
        var dataBayar = [];
        function saveToDB() {
            dataReg;
            dataBayar = [];
            var simpanUrl = "{{ URL::to('transaksi/pelunasan/simpan') }}";

            dataReg = {
                "regnum": jQuery('input[name=regid]').val(),
                "tgl": jQuery('input[name=tgl]').val()
            };

            jQuery('input[type=checkbox][name=ckbayar[]]').each(function() {

                if (jQuery(this).attr('checked') == 'checked') {
                    var biayaId = jQuery(this).attr('value');
                    var nilai = unformatRupiahVal(jQuery('#txbiaya_' + biayaId).val());
                    var potongan = unformatRupiahVal(jQuery('#txpotongan_' + biayaId).val());
                    var harusbayar = unformatRupiahVal(jQuery('#harusbayar_' + biayaId).text());

                    //totalBayar += parseInt(unformatRupiahVal(parseInt(nilai)));                   
                    dataBayar[dataBayar.length] = {
                        "psbbiaya_id": biayaId,
                        "harusbayar": harusbayar,
                        "dibayar": nilai,
                        "potongan": potongan
                    };
                }
            });

            var berhasil = false;
            $.ajaxSetup({async: false});
            $.post(simpanUrl, {
                'datareg': JSON.stringify(dataReg),
                'databayar': JSON.stringify(dataBayar)
            }, function(data) {
                berhasil = true;
                //alert(data);
                //jQuery('#post-rest').html(data);
            });

            return berhasil;
        }


    });
</script>
@stop
