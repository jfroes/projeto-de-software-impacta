<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirme seu cadastro</title>
</head>

<body style="margin:0;padding:0;background-color:#f8f9ff;font-family:Arial,Helvetica,sans-serif;color:#1a1b20;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f8f9ff;padding:32px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:620px;background-color:#ffffff;border:1px solid #e1e2e9;border-radius:20px;overflow:hidden;">
                <tr>
                    <td style="padding:28px 24px;border-bottom:1px solid #e1e2e9;">
                        <table role="presentation" cellspacing="0" cellpadding="0">
                            <tr>
                                <td style="width:42px;height:42px;border-radius:14px;background-color:#006a6a;text-align:center;vertical-align:middle;color:#ffffff;font-size:20px;font-weight:bold;">E</td>
                                <td style="padding-left:12px;font-size:20px;font-weight:bold;color:#171d1d;">Estoque</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:32px 24px;">
                        <h1 style="margin:0;font-size:24px;line-height:1.3;color:#1a1b20;">Confirme seu cadastro</h1>
                        <p style="margin:16px 0 0;font-size:15px;line-height:1.7;color:#44474f;">Olá{{ !empty($name) ? ' ' . $name : '' }},</p>
                        <p style="margin:8px 0 0;font-size:15px;line-height:1.7;color:#44474f;">Recebemos seu cadastro no sistema de estoque. Para ativar seu acesso, clique no botão abaixo:</p>

                        <table role="presentation" cellspacing="0" cellpadding="0" style="margin:28px 0;">
                            <tr>
                                <td align="center" style="border-radius:999px;background-color:#006a6a;">
                                    <a href="{{ $confirmationLink }}" style="display:inline-block;padding:14px 22px;font-size:14px;font-weight:bold;line-height:1;color:#ffffff;text-decoration:none;">Confirmar cadastro</a>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:0 0 8px;font-size:13px;line-height:1.6;color:#73777f;">O link de confirmação pode expirar por segurança.</p>
                        <p style="margin:0 0 8px;font-size:13px;line-height:1.6;color:#73777f;">Se o botão não funcionar, copie e cole este endereço no navegador:</p>
                        <p style="margin:0;font-size:12px;line-height:1.6;word-break:break-all;color:#006a6a;">{{ $confirmationLink }}</p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:20px 24px;border-top:1px solid #e1e2e9;font-size:12px;line-height:1.6;color:#73777f;">
                        Se você não solicitou este cadastro, ignore esta mensagem.<br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

</html>
