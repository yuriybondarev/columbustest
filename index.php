<html>
<head>
<title>Импорт данных</title>
<meta charset='utf-8'>
</head>
<body>
<h2>Import CSV file into Mysql using PHP</h2>

    <div>
        <div>

        <form id="myform" name="myform" enctype="multipart/form-data" method="post" action="">
            <div class="container">
            <div class="row align-items-start">
            <div id="block1" class="col">
            <h4> Выберите файл CSV: </h4><br>
            <input id="file" type="file" name="f" accept="text/csv"><br>
            </div>
                </div>
                </div>
        </form>
        <button id="sbm-button">Отправить</button>

        </div>
    </div>
    <?php
    include "db.php";
    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
      }
    ?>
    <script src="jquery-3.3.1.min.js"></script>
    <script>
            var address="process.php";
            $("#sbm-button").click(async function(){    //should be asynс
                if(document.getElementById("file").files.length === 0){
                    alert("Не выбран файл");
                    return 0
                }
                console.log("Started")
                var myform = document.forms.myform;
                let response = await fetch(address, {
                    method: 'POST',
                    body: new FormData(myform)
                });
                let result = await response.text();
                //console.log(result);
                var myBlob = new Blob([result], {type: 'text/csv'});
                var url = window.URL.createObjectURL(myBlob);
                var anchor = document.createElement("a");
                anchor.href = url;
                anchor.download = "stat.csv";
                anchor.click();
                window.URL.revokeObjectURL(url);
                //document.removeChild(anchor);
            })
        </script>
</body>
</html>