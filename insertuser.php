<?php

                #connect to DB
                $servername="sql.njit.edu";
                $user="fdm8";
                $password="dnPvZprB";
                ($conn=mysql_connect($servername, $user, $password) or die(mysql_error()));
                $query="use fdm8";
                ($result=mysql_query($query) or die(mysql_error()));
                #Insert into db with encrpyted password
                $u=$_POST['username'];
                $p=$_POST['password'];
                $t=$_POST['type'];
                $p=sha1($p);
                $query="insert into logins (username, password, type) VALUES ('$u', '$p', '$t')";
                ($result=mysql_query($query) or die(mysql_error()));

?>
