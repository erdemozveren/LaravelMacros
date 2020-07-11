@extends('laravelmacros::master')

@section('content')
<div class="row">
    <div class="col-md-4 well">
            <form action="return false;">
                    <h4>Select Table</h4>
                    @if($tables)
                    {!!Form::select("table_name",$tables,null,["class"=>"form-control","id"=>"table_name"])!!}
                    @else
                    <input type="text" id="table_name" class="form-control" placeholder="Table name" />
                    @endif
                    <hr><h4>Add Relation Field</h4>
                    <input type="text" id="relationName" class="form-control" placeholder="Field name" />
                    <br>
                    <input type="text" id="relationSource" class="form-control" placeholder="Data Source" />
                    {{-- <select id="fieldType" class="form-control">
                        <option value="text">Text</option>
                        <option value="textarea">Textarea</option>
                        <option value="email">Email</option>
                        <option value="password">Password</option>
                        <option value="number">Number</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="select">Select</option>
                    </select> --}}
                    <br>
                    <input name="addRelationButton" class="btn" type="button" value="Add" onclick="addRelation();" />
                </form>
                <h4>Relations</h4>
                <ul id="relations"></ul>
                <form action="return false;">
                    <input type="button" class="btn"  value="Generate" onclick="generateCode();" />
                </form>
    </div>
    <div class="col-md-4 break" >
        <h4>Predicted Simple Validation Rules</h4>
        <div id="rules">

        </div>
    </div>
    <div class="col-md-4 break">
        <h4>formFields() function for Model</h4>
        <div id="function">

        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h4>Form Preview</h4>
        <div id="formpreview">

        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
var fieldId = 0; // used by the addField() function to keep track of IDs
formJson=[];
function addRelation() {
    fieldId++;
    var relationName = document.getElementById('relationName').value;
    var relationSource = document.getElementById('relationSource').value;
    formJson[fieldId] = {
        "id":fieldId,
        "name":relationName,
        "source":relationSource,
    };
    //addEl('prew', 'p', 'field-' + fieldId, html);
    addEl('relations', 'li', 'r-' + fieldId, "<b>Name:</b> "+relationName+"&nbsp;&nbsp;&nbsp;&nbsp;<b>Data Source:</b> "+relationSource+' <input type="button" value="-" onclick="removeEl(\'r-' + fieldId + '\');"/>');
}
function generateCode() {
    $.ajax({
        url:'{{route('laravelmacros.dev.generateform')."?_token=".csrf_token()}}',
        method:"POST",
        data:{"relations":formJson.filter(v=>typeof v != 'undefined'),"table":$("#table_name").val()},
        success:function(res) {
            if(typeof res=='string') {
                
                alert("Error :"+res);
            }else {
                
            try {
            $("#rules").html(res.rules);
            $("#function").html(res.function);
            $("#formpreview").html(res.preview);
            }catch(err) {
                console.error("Error occured!",err,res);
                alert("Error :"+res);
            }
            }
        },
        error:function(err) {
            console.warn("err",err);
        }
    });
}
</script>
@endsection
@section('css')
    <style>
    .break {
        white-space: pre;
  word-wrap: break-word;
  color: #961751;
  overflow-y:auto;
    }
    </style>
@endsection