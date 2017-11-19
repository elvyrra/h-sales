<input type="hidden" value="{{{ $content }}}" id="h-sales-template-init-value"/>



{assign name="Pageheader"}
    <div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="Pageheader">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsePageheader" aria-expanded="true" aria-controls="collapsePageheader">
          {text key='h-sales.template-form-pageHeader-panel-title'}
        </a>
      </h4>
    </div>
    <div id="collapsePageheader" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="Pageheader">
      <div class="panel-body">
        	{{ $form->fieldsets['pageHeader'] }}
      </div>
    </div>
  </div>
{/assign}

{assign name="DocumentHeader"}
    <div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="DocumentHeader">
        <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDocumentHeader" aria-expanded="false" aria-controls="collapseDocumentHeader">
          {text key='h-sales.template-form-documentHeader-panel-title'}
            </a>
        </h4>
    </div>
    <div id="collapseDocumentHeader" class="panel-collapse collapse" role="tabpanel" aria-labelledby="DocumentHeader">
        <div class="panel-body">
            {{ $form->fieldsets['documentHeader'] }}
      </div>
    </div>
  </div>
{/assign}

{assign name="DocumentBody"}
	<div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="DocumentBody">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDocumentBody" aria-expanded="false" aria-controls="collapseDocumentBody">
          {text key='h-sales.template-form-documentBody-panel-title'}
        </a>
      </h4>
    </div>
    <div id="collapseDocumentBody" class="panel-collapse collapse" role="tabpanel" aria-labelledby="DocumentBody">
      <div class="panel-body">
        {{ $form->fieldsets['documentBody'] }}
      </div>
    </div>
  </div>
{/assign}

{assign name="FootPage"}
	<div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="FootPage">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFootPage" aria-expanded="false" aria-controls="collapseFootPage">
         {text key='h-sales.template-form-footPage-panel-title'}
        </a>
      </h4>
    </div>
    <div id="collapseFootPage" class="panel-collapse collapse" role="tabpanel" aria-labelledby="FootPage">
      <div class="panel-body">
            {{ $form->fieldsets['pageFooter'] }}
      </div>
    </div>
  </div>
{/assign}

{assign name="edition"}
    {{ $form->fieldsets['identity'] }}
    <div class="clearfix"></div>

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  	
    	{{$Pageheader}}

    	{{$DocumentHeader}}

    	{{$DocumentBody}}

   	    {{$FootPage}}
    </div>
{/assign}


{assign name="preview"}
    <!-- Page header -->
    <table id="PageHeader" width="100%" height="5%">
        <tbody>
            <tr>
                <td class="col-xs-4 text-left" >
                    <a e-style="{'color': pageHeader.color, 'font-family': pageHeader.fontFamily, 'font-size': pageHeader.fontSize, 'font-weight': pageHeader.displayBold, 'font-style': pageHeader.displayItalic, 'text-decoration': pageHeader.displayUnderline}" e-text="pageHeader.displayLeft"></a>
                </td>

                <td class="col-xs-4 text-center">
                    <a e-style="{'color': pageHeader.color, 'font-family': pageHeader.fontFamily, 'font-size': pageHeader.fontSize, 'font-weight': pageHeader.displayBold, 'font-style': pageHeader.displayItalic, 'text-decoration': pageHeader.displayUnderline}" e-text="pageHeader.displayCenter"></a>
                </td>

                <td class="col-xs-4 text-right">
                    <a e-style="{'color': pageHeader.color, 'font-family': pageHeader.fontFamily, 'font-size': pageHeader.fontSize, 'font-weight': pageHeader.displayBold, 'font-style': pageHeader.displayItalic, 'text-decoration': pageHeader.displayUnderline}" e-text="pageHeader.displayRight"></a>
                </td>
            </tr>
        </tbody>
    </table>

    <hr e-show="pageHeader.separator">

    <!-- Document header -->
    <table id="DocumentHeader" width="100%" height="30%">
        <tbody>
            <tr>
                <td class="col-xs-4 text-left" e-style="{'color': documentHeader.color, 'font-family': documentHeader.fontFamily, 'font-size': documentHeader.fontSize, 'font-weight': documentHeader.displayBold, 'font-style': documentHeader.displayItalic, 'text-decoration': documentHeader.displayUnderline}" e-text="documentHeader.displayLeft">
                </td>

                <td class="col-xs-4 text-center" e-style="{'color': documentHeader.color, 'font-family': documentHeader.fontFamily, 'font-size': documentHeader.fontSize, 'font-weight': documentHeader.displayBold, 'font-style': documentHeader.displayItalic, 'text-decoration': documentHeader.displayUnderline}" e-value="documentHeader.displayCenter">
                </td>

                <td class="col-xs-4 text-right" e-style="{'color': documentHeader.color, 'font-family': documentHeader.fontFamily, 'font-size': documentHeader.fontSize, 'font-weight': documentHeader.displayBold, 'font-style': documentHeader.displayItalic, 'text-decoration': documentHeader.displayUnderline}" e-value="documentHeader.displayRight">
                </td>
            </tr>
        </tbody>
    </table>

    <hr e-show="documentHeader.separator">

    <!-- Document Body -->
    <table id="DocumentBody" width="100%" height="60%">
        <tbody>
            <!--
            <tr>
                <td class="col-xs-4 text-left" e-style="{'color': documentHeader.color, 'font-family': documentHeader.fontFamily, 'font-size': documentHeader.fontSize, 'font-weight': documentHeader.displayBold, 'font-style': documentHeader.displayItalic, 'text-decoration': documentBody.displayUnderline}" e-value="documentHeader.displayLeft">
                </td>

                <td class="col-xs-4 text-center" e-style="{'color': documentHeader.color, 'font-family': documentHeader.fontFamily, 'font-size': documentHeader.fontSize, 'font-weight': documentHeader.displayBold, 'font-style': documentHeader.displayItalic, 'text-decoration': documentHeader.displayUnderline}" e-value="documentHeader.displayCenter">
                </td>

                <td class="col-xs-4 text-right" e-style="{'color': documentHeader.color, 'font-family': documentHeader.fontFamily, 'font-size': documentHeader.fontSize, 'font-weight': documentHeader.displayBold, 'font-style': documentHeader.displayItalic, 'text-decoration': documentHeader.displayUnderline}" e-value="documentHeader.displayRight">
                </td>
            </tr>
            -->
        </tbody>
    </table>


    <hr e-show="pageFooter.separator">
    <!-- Page Footer-->
    <table id="PageFooter" width="100%" height="5%">
        <tbody>
            <tr>
                <td class="col-xs-4 text-left" e-style="{'color': pageFooter.color, 'font-family': pageFooter.fontFamily, 'font-size': pageFooter.fontSize, 'font-weight': pageFooter.displayBold, 'font-style': pageFooter.displayItalic, 'text-decoration': pageFooter.displayUnderline}" e-value="pageFooter.displayLeft">
                </td>

                <td class="col-xs-4 text-center" e-style="{'color': pageFooter.color, 'font-family': pageFooter.fontFamily, 'font-size': pageFooter.fontSize, 'font-weight': pageFooter.displayBold, 'font-style': pageFooter.displayItalic, 'text-decoration': pageFooter.displayUnderline}" e-value="pageFooter.displayCenter">
                </td>

                <td class="col-xs-4 text-right" e-style="{'color': pageFooter.color, 'font-family': pageFooter.fontFamily, 'font-size': pageFooter.fontSize, 'font-weight': pageFooter.displayBold, 'font-style': pageFooter.displayItalic, 'text-decoration': pageFooter.displayUnderline}" e-value="pageFooter.displayRight">
                </td>
            </tr>
        </tbody>
    </table>

{/assign}


{assign name="formTemplate"}
    <div class="row">
        {{ $form->fieldsets['_submits'] }}
        <div class="col-md-5">
        	{{$edition}}
        </div>

        <div id="preview" class="col-md-7">
        	{{$preview}}
        </div>
    </div>
{/assign}

{form id="{$form->id}" content="{$formTemplate}"}
