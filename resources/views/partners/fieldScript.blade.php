<script src="{{ asset('/public/js/ajaxsetup.js') }} " type="text/javascript"></script>
<script src="{{ asset('/public/js/addDays.js') }} " type="text/javascript"></script>
<script src="{{ asset('/public/js/required.js') }} " type="text/javascript"></script>
<script src="{{ asset('/public/js/sweetalert.js') }} " type="text/javascript"></script>

<script type="text/javascript">
    $(function () {

        ajaxSetup();

        $('#taxnumber').inputmask();
        $('#bankaccount').inputmask();
        $('#phonenumber').inputmask();

        RequiredBackgroundModify('.form-control')

        $('#postcode').change(function() {
            let postcode = $('#postcode').val() != 0 ? $('#postcode').val() : -99999;
            let settlement_id = $('#settlement_id').val() != 0 ? $('#settlement_id').val() : -99999;
            if( postcode != -99999 ){
                $.ajax({
                    type:"GET",
                    url:"{{url('postcodeSettlementDDDW')}}?postcode="+postcode,
                    success:function(res){
                        if(res){
                            console.log(res)
                            $("#settlement_id").empty();
                            // $("#settlement_id").append('<option></option>');
                            $.each(res,function(key,value){
                                $("#settlement_id").append('<option value="'+value.id+'">'+value.name+'</option>');
                            });

                            if ( settlement_id != -99999 ) {
                                $('#settlement_id').val(settlement_id);
                            }

                        }else{
                            $("#settlement_id").empty();
                        }
                    }
                });
            }else{
                $("#settlement_id").empty();
            }
        });


    });
</script>
