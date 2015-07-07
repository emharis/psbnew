@extends('_layouts.default')

@section('main')
<div class="span12">      

    <!--widget form input-->
    <div class="widget " id="formInputPengeluaran">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Edit Data Pengeluaran</h3>
            <div class="pull-right" style="padding-right: 10px;">

            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content"> 
            <style>
                .table input{
                    margin: 0;
                }


            </style>
            <form action="pengeluaran/postedit" method="POST" >
                <input type="hidden" name="dataid" value="{{$data->id}}"/>
                <table  class="table table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <td class="span2" >Tanggal</td>
                            <td>
                                <input type="text" value="{{date('d-m-Y',strtotime($data->tgl))}}" name="tgl" class="input-small datepicker" required />
                            </td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>
                                <input type="text" value="{{$data->keterangan}}" name="keterangan" class="input-block-level" maxlength="50" required />
                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td>
                                <input type="text" value="{{number_format($data->jumlah,0,',','.')}}" name="jumlah" id="txJumlah" class="input-medium uang" required />
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="pengeluaran" id="btnReset" class="btn btn-warning">Cancel</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

    <!--widget data table-->
    

</div> <!-- /span8 -->

<br />

@stop

@section('custom-script')

<script type="text/javascript">
    jQuery(document).ready(function () {
        
    });
</script>
@stop
