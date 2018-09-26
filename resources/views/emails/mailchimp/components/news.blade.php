<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
    <tr>
        <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
            <!--[if mso]>
            <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                <tr>
            <![endif]-->

            <!--[if mso]>
            <td valign="top" width="600" style="width:600px;">
            <![endif]-->
            <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%"
                   class="mcnTextContentContainer">
                <tbody>
                <tr>

                    <td valign="top" class="mcnTextContent"
                        style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">

                        <h4 class="null">{{ $news->name }}</h4>
                        <br>
                        <strong>Thématique</strong> : {{ $news->thematic->name }}<br>

                        @if(!empty($news->closing_date))
                        <strong>Date de clôture&nbsp;</strong>: {{ $news->closing_date->format('d/m/Y') }}<br>
                        @endif

                        @if(!is_null($callForProjects->subthematic))
                            <strong>Sous-thématique</strong>&nbsp;: {{ $callForProjects->subthematic->name }}<br>
                        @endif

                        @if(!$news->perimeters->isEmpty())
                            <strong>Périmètres</strong>&nbsp;: {!! $news->perimeters->unique()->sortBy('name')->pluck('name')->implode(', ') !!}<br>
                        @endif

                        @if(!$news->projectHolders->isEmpty())
                            <strong>Porteurs du dispositif&nbsp;</strong>: {!! $news->projectHolders->unique()->sortBy('name')->pluck('name')->implode(', ') !!}<br>
                        @endif

                        <br>
                        {{ \Illuminate\Support\Str::words($news->objectives, 50) }}
                    </td>
                </tr>
                </tbody>
            </table>
            <!--[if mso]>
            </td>
            <![endif]-->

            <!--[if mso]>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
    <tr>
        <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
            <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%"
                   style="min-width: 100%;border-top: 1px solid #EAEAEA;">
                <tbody>
                <tr>
                    <td>
                        <span></span>
                    </td>
                </tr>
                </tbody>
            </table>
            <!--
                            <td class="mcnDividerBlockInner" style="padding: 18px;">
                            <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
            -->
        </td>
    </tr>
    </tbody>
</table>