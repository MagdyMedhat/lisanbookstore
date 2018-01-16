<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>

    //        var resource;

    var addBtn = "<div class='col-md-6 addBtnContainer'><a href='#' class='btn btn-default addBtn'>Add Resource</a></div>";


    //flag to prevent form from submission if there are any errors
    //all validation is done at client side
    var errors = false;

    //Resource sub-form components
    var emptyCol = "<div class='col-md-4'></div>";

    var resourceErorrMsg = "<div class='alert alert-danger resErrorMsg' hidden='true'><p></p></div>";

    var qttyErrorMsg = "<div class='alert alert-danger qttyErrorMsg' hidden='true'><p></p></div>";

    var resourceNameLbl = "<div class='col-md-4'><label>Title</label></div>";

    var codeLbl = "<div class='col-md-4'><label>Code</label></div>";

    var qttyLbl = "<div class='col-md-4'><label>Quantity</label></div>";

    var codeInput = "<div class='col-md-4 form-group codeInput'><input type='text' class='form-control'></div>";

    var qttyInput = "<div class='col-md-4 form-group qttyInput'><input type='number' class='form-control'></div>";

    var resourceName = "<div class='col-md-4 resourceName'><p></p></div>";

    var deleteItem = "<div class='col-md-12'><a class='btn btn-sm btn-danger deleteItem'><i class='glyphicon glyphicon-remove'></i></a></div>";

    var resourceObject = "<input type='hidden' class='resource' />";


    //        $('document').ready(function(){
    $('#controls')
            .append(addBtn)
    //                    .children('.addBtnContainer').children('a').removeAttr('disabled').prop('disabled', false);
    $('#controls').on('click', '.addBtn', function(){
                $(this).remove();

                $('#controls').append(
                        "<div class='resourceInput panel panel-default col-md-12 resourceInput'>" +
//                        "<div class='panel-heading'>" +
                        deleteItem +
                        "<div class='panel-body'>" +

                        qttyErrorMsg +
                        resourceErorrMsg +
//                                "</div>" +
                        resourceNameLbl +

                        codeLbl +
                        qttyLbl +
                        resourceName +
                        codeInput +

                        qttyInput +

                        resourceObject +
                        "</div>" +
                        "</div>" +
                        addBtn
                );

            })
            .on('blur', '.resourceInput .codeInput', function(){
                var resourceCodeField = $(this);
                if(resourceCodeField.children('input').val() != '')
                {
                    getResource(resourceCodeField);
                }

            })
            .on('blur', '.resourceInput .qttyInput', function(){
                var resourceQttyField = $(this);
                if(resourceQttyField.children('input').val() != '')
                {
                    validateQtty(resourceQttyField);
                }

            })
            .on('click', '.deleteItem', function(){
                var container = $(this).parents('.resourceInput').remove();
            });

    function getResource(resourceCodeField)
    {
        if(resourceCodeField.children('input').val() != '')
        {
            $.post('Retail/getResource',
                    {'_token': $('meta[name=csrf-token]').attr('content'),
                        code : resourceCodeField.children('input').val()}
                    )
                    .done(function(data){

                        if(data.resource)
                        {

                            var resource = resourceCodeField.parent().children('.resource');
                            resource.val(JSON.stringify(data.resource));
                            resourceCodeField.parent().children('.resErrorMsg').hide();
                            resourceCodeField.parent().children('.resourceName').children('p').html(data.resource.name);
//                                console.log();
                            if(resourceCodeField.parent().children('.qttyInput').children('input').val() != '')
                            {
                                validateQtty(resourceCodeField.parent().children('.qttyInput'));

                            }

                        }
                        else
                        {
                            resourceCodeField.parent().children('.resErrorMsg').children('p').html("A resource with the provided code could not be found");
                            resourceCodeField.parent().children('.resErrorMsg').show();
                            resourceCodeField.parent().children('.qttyErrorMsg').hide();
                            errors = true;
                        }

                    });
        }
        else
        {
            resourceCodeField.parent().children('.resErrorMsg').children('p').html("A resource code is required");
            resourceCodeField.parent().children('.resErrorMsg').show();
            resourceCodeField.parent().children('.qttyErrorMsg').hide();
            errors = true;
        }

    }

    function validateQtty (resourceQttyField)
    {
//                console.log(resourceQttyField);
        var qtty = resourceQttyField.children('input').val();
        if(resourceQttyField.parent().children('.resource').val() != '')
        {
//                    console.log(resourceQttyField.parent().children('.resource').val());
            var resource = $.parseJSON(resourceQttyField.parent().children('.resource').val());
//                    console.log(qtty);

            if(resource.stock_count - qtty < 0)
            {
                resourceQttyField.parent().children('.qttyErrorMsg').children('p').html("Quantity greater than stock. Stock: " + resource.stock_count);
                resourceQttyField.parent().children('.qttyErrorMsg').show();
                errors = true;
            }
            else if(qtty == 0)
            {
                resourceQttyField.parent().children('.qttyErrorMsg').children('p').html("Quantity must be greater than zero");
                resourceQttyField.parent().children('.qttyErrorMsg').show();
                errors = true;
            }
            else
            {
                resourceQttyField.parent().children('.qttyErrorMsg').hide();
                errors = false;

            }
        }
        else if(resourceQttyField.parent().children('.resource').val() == '' && qtty == '')
        {
            resourceQttyField.parent().children('.qttyErrorMsg').children('p').html("Quantity is required");
            resourceQttyField.parent().children('.qttyErrorMsg').show();
            errors = true;
        }



    }
    function validateForm()
    {
        var resources = [];

        var resourcesPanels = $('#controls').children('.resourceInput');
        $.each(resourcesPanels, function(index, resourcePanel){
            console.log($(resourcePanel).children('.panel-body').children('.codeInput').children('input'));
            var qttyInput = $(resourcePanel).children('.panel-body').children('.qttyInput');
            var codeInput = $(resourcePanel).children('.panel-body').children('.codeInput');
            getResource(codeInput);
            validateQtty(qttyInput);
            if(!errors)
            {
//                        console.log($.parseJSON($(resourcePanel).children('.panel-body').children('.resource').val()).resource);
                var res =$.parseJSON($(resourcePanel).children('.panel-body').children('.resource').val());
                var id = res.id;
                var code = res.code;
                var qtty = $(qttyInput).children('input').val();
                var resourceObj = {
                    id: id,
                    code: code,
                    qtty: qtty,
                };
//                        console.log(resourceObj);
                resources.push(resourceObj);
            }
        });

        if(!errors)
        {
//                    console.log((resources));
            $('#resources').val(JSON.stringify(resources));
            return true;
        }
        else
            return false;


    }

//    function fillForm()
//    {
//        $.post('Retail/getTransactionResources', {'_token': $('meta[name=csrf-token]').attr('content'),
//            id: $('#transactionId').val() }, function(data){
//            $('#resources').val(JSON.stringify(data));
////            console.log($('#resources').val());
//            //data is transaction resources
//            $('#controls').children('.addBtn').remove();
//            $.each(data, function(index, resource){
//
//                $('#controls').append(
//                        "<div class='resourceInput panel panel-default col-md-12 resourceInput'>" +
////                        "<div class='panel-heading'>" +
//                        deleteItem +
//                        "<div class='panel-body'>" +
//
//                        qttyErrorMsg +
//                        resourceErorrMsg +
////                                "</div>" +
//                        resourceNameLbl +
//
//                        codeLbl +
//                        qttyLbl +
////
//                        fillFields(resource) +
//
//                        "</div>" +
//                        "</div>"
//                );
//            });
//        });
//
////        var resources = $('#resources').val();
////        console.log($('#resources').val());
//
////        $.each()
//    }
//
//    function fillFields(resource)
//    {
//        var codeInput = "<div class='col-md-4 form-group codeInput'><input type='text' class='form-control' value='"+ resource.code +"'></div>";
//
//        var qttyInput = "<div class='col-md-4 form-group qttyInput'><input type='number' class='form-control' value='"+ resource.qtty +"'></div>";
//
//        var resourceName = "<div class='col-md-4 resourceName'><p>"+ resource.name +"</p></div>";
//
//        var resourceObject = "<input type='hidden' class='resource' value='"+ JSON.stringify(resource) +"'/>";
//
//
//        return  resourceName + codeInput + qttyInput + resourceObject;
//    }




    //        });

</script>

<style>
    #submit{
        margin-top : 20px;
    }
    .panel{
        padding-top: 20px;
    }
    .deleteItem{
        float:right;
    }

    .qttyErrorMsg, .resErrorMsg{
        margin-top:20px;
    }

</style>