<?php
class MySecret
{
    //config for MrBot Line & Dialogflow
    public static $dbDatabase = 'db_euaangkoon_test';
    public static $dbUser = 'itpcs';
    public static $dbPass = 'Pcs@1234';
    public static $dbHost = 'mail.cc.pcs-plp.com';
    public static $dbPort = '3306';

    public static $BotId = '@963pjzsd';
    public static $lineAccessToken = 'ZULjuFtGULWLryPdnhM1dhpzS1vZCU3uQBBGcziOBi/SSTuLxQ8ZvMMJSOHm7KpbB0936WVnnL0+oLeHlgAtbGeYN4Hmi6SHcjHEa905th5Z4yZAdpwxhh+kqsSb3CNIw1kGboT6nCnCaOE/H/UUxAdB04t89/1O/w1cDnyilFU=';
    public static $lineSecret = 'ddb9e9c549dfc5632a72a50f8c959cda';
    //liff related
    public static $lineLiffId = '1656323850-035DWlmn';
    public static $liffRegisterURL = 'https://liff.line.me/1656323850-035DWlmn';
    public static $lineGetImageLiffId = 'yyyy';

    public static $OpenAIAPIKey = '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';
    public static $DFFallbackLearning = false;
    public static $ChatEngine = 'DialogFlow'; //choice is DialogFlow*, Ada, Babbage, Curie, Davinci;

    public static $aqiApiKey = '856635bf-e3ac-4d0e-b649-9c80b7c92b51'; //must be updated every 360 days (1 year) - Exp: 20230501 https://www.iqair.com/dashboard/api (delete old and create the new one)
    public static $dialogFlowUrl = 'https://dialogflow.cloud.google.com/v1/integrations/line/webhook/58d25435-5452-4e6b-b2d9-4f53e1b50055';
    public static $dialogFlowHost = 'dialogflow.cloud.google.com';
    public static $openWeatherMapApiKey = '559502c40bc31763e2af005c0cd26bdd';
    public static $abdul_id = 'ba0fd48e97328282ec2e43f9b0153878';
    public static $abdulBotId = '505240140856865_angelbot49';

    public static $longDoMapApiKey = '0183e4118020eef6052d2b00f8bec03f';
    public static $googleMapApiKey = 'AIzaSyCfsN6CfVaMaLlDuOfLU6UlBIxKvvb7s0s';
    public static $opendDataApiKey = 'iAPatceTkdXBpI0NUWa3V5gq3ljwtpwq';

    public static $tempOnlineAddr = 'http://localhost/temponlineapi';
    //public static $tempOnlineApiKey = 'demo:dixell'; //th20210716 not use anymore

    //google API config section
    public static $dfClientConnect = [
        "type" => "service_account",
        "project_id" => "mrbot-vtig",
        "private_key_id" => "d291512b3078172792c92fdce172e71fae2197ce",
        "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEugIBADANBgkqhkiG9w0BAQEFAASCBKQwggSgAgEAAoIBAQCkd8p/DX1GYoCT\nNpDLEiZgA3t098ZYKU1tQVwtIR22Tq5qIi4d8OoGOZKgGvcJqzoiX3tp2pCbHudc\nump9ESrSZ+EWROQDLF9H0GGWH27b/FkV+Yn+k8sU9sliCaYJDcUzuJ21zHy6WV+E\n39lFUz5iDeEs3W080DeuCYTsZEozds4Q7t72ec4jPm27Kct1t6DCluwoteKppHvL\nnNHCEkj1zwrZkdzvhYyVd7UdGwKufpsj/tE7SDFxogg/zXcVPes7GuTSWUCVjseV\nvL6X6UbFYIsu2WFJwgBxVXab/fscJoArwv00iOPSAOfA/mZPy01bOIg0ULSYB1zn\nqH4vAs9hAgMBAAECgf82EoGrmUPBYEvlb+CAOKIP7xUn36PWWGicWGDLIELPLWR/\n1bz+cGErVW0KNn4B2nRtLfc6q3aKNB7c3cJ6W//i1+7+OKgTuFhFxBJRc67UT02l\na+Vyos9MlSv15ODcbn/nVqCDT40Ht1qFf73EjRnKzcVlJWeaFtriMpRWeU1BSHHO\nETTgmwxM2AxaC71pPALJZtBfbV/K3dcUcz3oIOk9zESVzHtYOVXcyktpArmENGgX\noDNyrLMIAg9zm8lGujopC1hZrK1nVcfTiiYrv3gztzwDSAla4OluP2Cg7o3cxzFk\nMsUku5lGUD5bz9AcNWhKWlPWmAbMcNqlyJ/Ew0kCgYEA0+9Gz4ZBl++d7pGtJJY/\nUDUOpBPGXJr4NmVWIaOumT+cOghi047vVRQQBx4mm/DDgp9D46ZfvBE9mjtXyeAi\nbhJjPkFTHoOj+4hKV8IP41aPM040gvHs9yxw95gi3BLmSbibvzXFTNeN7rjoLxCn\nIlwyoKQww0jgZLf4zZ/bWz0CgYEAxqn8LQJHpYGEEA5VVuisQktj+7btQHJQHQII\n4LZbHZqyBuhMvepaW73ayEDw8xQfs7/xSqH1spiJqfU+tiz0cddKIxXHsk62BdvO\nvOFQmNAXfjdH8zgnXHqmOGvZjSivD+obF3FSUH4C4rXLrpzbn5fU4WfPPrCVBBVp\n67YGVvUCgYBnOgeCcwEl8Pc6yUfNJ0VlWsJr1pnqZyz4ybj/H4ueZyY/+e+w3dDi\n3qfD38Ksd8OyrsJRcqr0nm0j3z2uPXZnqJsgKo9CsJnBnSugvQwiDfon4jKfiRiD\nd+j6H+byzF3QkJODubwE5oTiPrwQmIrfqIqcRfzeUXPCev07ol4kfQKBgEFwtRTO\nb3NhWnM/hXT/Z97enqzH8RcNkL49cVc0Oodh8cq8sqrMi780puDYI4au1lKLo5wG\nBb0y6gYGNwYjgNIPLOipwAJIU0VSxqMJRVdRFKwK4bSIhs67yA1F2X/aKvB/GTV7\nqrXBDIpJgDKgkOfdR86IN4ha+ntB4oY2i5gRAoGAdIMbsBmEaxBfxZxvBEQ82rbU\nuYMawZ147bNB+rJShMJGzX+6K6qNU0yiRgku+koppifsJnNeDGc56o6JV96icbcz\nGm+CQZkwfcmbYgdCZ2Cqr9J3UlDGii2up0aXL8UvrrOaqCAL0m2SkEBsS+85Zn5w\nxSpTCWkCvJzuR6WATsg=\n-----END PRIVATE KEY-----\n",
        "client_email" => "mrbotsa@mrbot-vtig.iam.gserviceaccount.com",
        "client_id" => "105723032316628238263",
        "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
        "token_uri" => "https://oauth2.googleapis.com/token",
        "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
        "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/mrbotsa%40mrbot-vtig.iam.gserviceaccount.com"
    ];
    public static $ggsAttendanceConnect = [
        "type" => "service_account",
        "project_id" => "nifty-might-312104",
        "private_key_id" => "c8099ce4900d7b5d08b208548c5f9a63ffae8aad",
        "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDTKxOMlQzePnNj\nnFAM64fzkmMUZu4qp32msPulEinTCcpWj8OOHRzUdVQMLJc4vGn1fWi4VH6t5kaJ\nd5eFv1CfqvJRrW8NfoS0ArZIkkDZ5kl5Zf4yJgrC8RhPqiRtRB6ANY2Iu5YI7NPx\n+SIKISVYPsHahFYYTjX4JI6gtguXhj55O3KDX9X4xgA2Q1z6j4Yb8iqrBIp/XuVH\nH9oAdhyqfxlgqKOHfjxEzctPVklK4eT0O4kQREWnbEzOLLjcse4ES9kNAQR2IDCo\n08bDCmSoLH67QPbKEfkLh399JAJ8bjd00zjA+QuUK2o5atOMjG8Mf9l8rPwXPFQj\nRpyTuk21AgMBAAECggEAY3V5BjBXuL+aUpLXg1ZWGKtcnkniqFVuEZpvU+7LozoL\nwpyA40kkAI9ocDl6Wj8n+ve/4H3vkpGQrIOW6uhSnXmDG2RAF499ClnyqBi2kcrs\n1VBsGwue6vVqWW9OK+a3JPTUPk/4GSkOpHwOg83bzIX2gSjuchE4SzFQujI0IH+/\nj50Nf5ewOThFNX+/AyHgKXUJ+PfJR0rqSQtG4XcuSRAsHXEdM9eHqlDITjsRmsGp\nd7pmeJVrFX3aK2O1w7ur/Y6q40M/HFHQg87WyuEBXvLItEO9tcVEBbqwH6HhyuG3\nC657vbOWs+PAqlPw/M7rM9mwnrLaUDTBqZLA79A2GwKBgQDtlPiBFoRAskgAjpEV\nQMA5mtROHjhJTdTOHzJGr4QSehWMYtakpScS/musORprMow9llzb0C2QFuXq6jf2\n4KuKzvKZcBNGSPXvHDxnnuSGnC+lq2VZitYA0ANdWDzsjEiS2/CM8VBhBdY32UES\nwaQyiPRB3MEdyF+fa+6lFvgqOwKBgQDjiecZizw+2oPM8TCS3bWLiESkf4v9hq3T\nmOwnW4cI6f4QupU4NqJBOUacYHhaf8s/8X7V1KSdLq/YLtbWbr7YiOmp8/fN0DQl\nvoHLlMrGBEo+71XXEKy3sDIh6uXWkK4r3pE5r88ckjw6jFiM/19qAGR/NaLV6y6M\nIh+P/wX4zwKBgBKHNqYikmfVP4ZDmA73QMZ9S6dX9f3JgxocFriqgXtLaBjNsH2g\nn558lvsUbPoFNCitbEp8PsFo979NStYHCXnGz+aldetaT0u5gQB3xMy2q4SZDEti\nZ3QixNBnzECKZDKH0oe7XhBi+yTZ3ZhP37VNNvdX9vuSn9p3+WGInAv3AoGABF07\nwoCqKiZ0yrSBkv+PoNp/Pox3ueggY2OWe/bEc0ZRqi55+DcMC6Y2lX9AL7QtyM8v\n+Jf4hE9F7iaP1lMPdAXEPY9BXIA2z9aElMwIy51/cw+SHOrj9S36+C2SNPhXbt34\n+RtHJKwlXZYdiK7JPLY/NzVnJyU4olVxN4jTq38CgYEApcNOzq6p9NCr/5wIITKN\nO64553DGMWNFW5tnRcTWBJTt8yQPdubiHXn5+2C4rdMY5saq0PLUFQqr6LtgUdf3\npFFifzYSJtAtx9vFCd+FkVhRZOt0t0zb/h4K8GA3KuAeTPsPyhKFBZ9i4iIeu15f\nBB/u7y+ZrkBT19KNQdnOTnI=\n-----END PRIVATE KEY-----\n",
        "client_email" => "googlesheet@nifty-might-312104.iam.gserviceaccount.com",
        "client_id" => "116664078229926551445",
        "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
        "token_uri" => "https://oauth2.googleapis.com/token",
        "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
        "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/googlesheet%40nifty-might-312104.iam.gserviceaccount.com"
    ];
    public static $attendanceSheetId = '10vDodPO_19dgXppjx6Ww5W_lnAp-yX5sEOfwwsXsRHE';
    public static $attendanceSheetGId = 554394394;

    //Normal config section
    public static $BotName = "Jai";
    public static $BotNameTH = "ใจ๋";
    public static $BotRealName = "๋Jitjai";
    public static $BotRealNameTH = "จิตใจ";
    public static $BotSexIsGirl = true;

    public static $TrainURLPrivate = true;
    public static $CustomIntentPrefix = "JaiCustom_";

    //th20210810 excel file & e-mail related 
    // public static $tempFilePath = '/var/www/temp/';
    public static $tempFilePath = '/var/www/ebooking/euaangkoon_test/angelbot/jaibot/temp';
    public static $uploadQRPath = 'upload/qr/';

    public static $mailHost = 'mail.cc.pcs-plp.com';
    public static $mailSMTPAuth = true;
    public static $mailUsername = 'jaibot.jj@cc.pcs-plp.com';   //username
    public static $mailPassword = 'A39z%TFwyA';   //password
    public static $mailSMTPSecure = 'tls';
    public static $mailSMTPPort = 587;
    public static $mailFromAddr = 'jaibot.jj@cc.pcs-plp.com';
    public static $mailFromName = 'Jai Bot (Nong Jitjai)';
}
