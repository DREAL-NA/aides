@extends('emails.mailchimp.layout')

@section('content')
    <tr>
        <td align="center" valign="top" id="templateBody" data-template-container>
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                <tr>
                    <td align="center" valign="top" width="600" style="width:600px;">
            <![endif]-->
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                <tr>
                    <td valign="top" class="bodyContainer">
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

                                                Découvrez les nouvelles aides pour le développement durable en Nouvelle -
                                                Aquitaine, destinées à tous : collectivités, associations, entreprises, citoyens, …
                                                Vous avez connaissance d’autres aides ? Communiquez-les-nous en répondant à cet e-mail.
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
                                <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 18px 18px 0px;">
                                    <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;">
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
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
                            <tbody class="mcnButtonBlockOuter">
                            <tr>
                                <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center"
                                    class="mcnButtonBlockInner">
                                    <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer"
                                           style="border-collapse: separate !important;border-radius: 3px;background-color: #0c6438;">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="middle" class="mcnButtonContent"
                                                style="font-family: Helvetica; font-size: 18px; padding: 18px;">
                                                <a class="mcnButton " title="Aller sur le site" href="{{ env('APP_URL') }}" target="_blank"
                                                   style="font-weight: bold;letter-spacing: -0.5px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Aller
                                                    sur le site</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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

                                                                    <span style="font-size:12px">Si le bouton ne fonctionne pas, copiez-collez l'url suivante dans votre navigateur : <a
                                                                                href="{{ env('APP_URL') }}/?utm_source=newsletter&utm_medium=email&utm_campaign=aides_de_la_semaine" target="_blank">{{ env('APP_URL') }}/?utm_source=newsletter&utm_medium=email&utm_campaign=aides_de_la_semaine</a></span>
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
                                           style="min-width: 100%;border-top: 4px solid #EAEAEA;">
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

                                                <h3 class="null">Les aides de la semaine</h3>

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

                        <?php // TODO : ici on a la boucle sur les actus ?>
                        @each('emails.mailchimp.components.news', $callsOfTheWeek, 'news')
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
@endsection
