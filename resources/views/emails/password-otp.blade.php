<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Eventora - Password Reset OTP</title>
</head>

<body
    style="
        margin:0;
        padding:0;
        background:#f4f6fb;
        font-family:Arial,Helvetica,sans-serif;
    "
>

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="background:#f4f6fb;padding:40px 15px;"
>

    <tr>
        <td align="center">

            <table
                width="100%"
                cellpadding="0"
                cellspacing="0"
                border="0"
                style="
                    max-width:560px;
                    background:#ffffff;
                    border-radius:18px;
                    overflow:hidden;
                    box-shadow:0 8px 30px rgba(16,24,40,0.08);
                "
            >

                <!-- HEADER -->

                <tr>

                    <td
                        align="center"
                        style="
                            background:#4567dd;
                            padding:30px 25px;
                        "
                    >

                        <div
                            style="
                                font-size:30px;
                                font-weight:800;
                                color:#ffffff;
                                letter-spacing:0.5px;
                            "
                        >
                            Eventora
                        </div>

                        <div
                            style="
                                margin-top:7px;
                                font-size:13px;
                                color:#e8edff;
                            "
                        >
                            Events made simple
                        </div>

                    </td>

                </tr>


                <!-- CONTENT -->

                <tr>

                    <td
                        style="
                            padding:40px 35px;
                            color:#172033;
                        "
                    >

                        <div
                            style="
                                font-size:24px;
                                font-weight:800;
                                margin-bottom:10px;
                            "
                        >
                            Password Reset
                        </div>


                        <div
                            style="
                                font-size:14px;
                                line-height:1.7;
                                color:#667085;
                                margin-bottom:25px;
                            "
                        >
                            We received a request to reset the password
                            for your Eventora account.
                        </div>


                        <div
                            style="
                                font-size:14px;
                                line-height:1.7;
                                color:#344054;
                                margin-bottom:18px;
                            "
                        >
                            Your One-Time Password (OTP) is:
                        </div>


                        <!-- OTP -->

                        <div
                            style="
                                text-align:center;
                                background:#f5f8ff;
                                border:1px solid #dce5ff;
                                border-radius:14px;
                                padding:22px 15px;
                                margin:0 0 25px;
                            "
                        >

                            <div
                                style="
                                    font-size:34px;
                                    font-weight:800;
                                    letter-spacing:8px;
                                    color:#4567dd;
                                "
                            >
                                {{ $otp }}
                            </div>

                        </div>


                        <div
                            style="
                                font-size:13px;
                                line-height:1.7;
                                color:#667085;
                                background:#fafafa;
                                border-radius:10px;
                                padding:13px 15px;
                                margin-bottom:25px;
                            "
                        >
                            This OTP is valid for
                            <strong style="color:#344054;">
                                10 minutes
                            </strong>.
                            Do not share this OTP with anyone.
                        </div>


                        <div
                            style="
                                font-size:14px;
                                line-height:1.7;
                                color:#667085;
                            "
                        >
                            If you did not request a password reset,
                            you can safely ignore this email.
                        </div>

                    </td>

                </tr>


                <!-- FOOTER -->

                <tr>

                    <td
                        align="center"
                        style="
                            background:#f8f9fc;
                            border-top:1px solid #edf0f5;
                            padding:22px 25px;
                        "
                    >

                        <div
                            style="
                                font-size:12px;
                                color:#98a2b3;
                                line-height:1.6;
                            "
                        >
                            © {{ date('Y') }} Eventora.
                            All rights reserved.
                        </div>


                        <div
                            style="
                                margin-top:5px;
                                font-size:11px;
                                color:#b0b7c3;
                            "
                        >
                            This is an automated email.
                            Please do not reply.
                        </div>

                    </td>

                </tr>

            </table>

        </td>
    </tr>

</table>

</body>
</html>