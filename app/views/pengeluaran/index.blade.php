@extends('_layouts.default')

@section('main')
<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Pengeluaran</h3>
            <div class="pull-right" style="padding-right: 10px;">

            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content" id="reg-content">    
            <style>
                .table input{
                    margin: 0;
                }
            </style>
            <form action="pengeluaran/addnew" method="POST" >
            <table  class="table table-bordered table-condensed">
                <tbody>
                    <tr>
                        <td class="span2" >Tanggal</td>
                        <td>
                            <input type="text" value="{{date('d-m-Y')}}" name="tgl" class="input-small datepicker" required />
                        </td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>
                            <input type="text" name="keterangan" class="input-block-level" maxlength="250" required />
                        </td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>
                            <input type="text" name="jumlah" id="txJumlah" class="input-medium uang" required />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="reset" class="btn btn-warning">Cancel</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

<br />

@stop

@section('custom-script')

<script type="text/javascript">
    jQuery(document).ready(function () {

    });
</script>
@stop