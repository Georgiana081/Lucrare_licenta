    <?php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'bookstore');
    
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if($link === false){
        die("EROARE: Nu s-a putut face conexiunea la baza de date. " . mysqli_connect_error());
    }
        function MesajAdaugare($text, $tip)
            {
                if(! isset($_SESSION['mesaje']))
                    $_SESSION['mesaje'] = [];
                $mesaj = [
                    'text' => $text ,
                    'tip' => $tip
                ];
                $_SESSION['mesaje'][] = $mesaj;
            }

        function MesajAfisare()
        {
            if(! isset($_SESSION['mesaje']))
                return;
            ?>
            <div class="container py-3">
                <?php
                foreach($_SESSION['mesaje'] as $mesaj)
                {
                    ?>
                        <div class="alert ms-auto alert-<?=$mesaj['tip']?>">
                            <?=htmlspecialchars($mesaj['text'])?>
                        </div>
                    <?php
                }
                unset($_SESSION['mesaje']);
                ?>
            </div>
            <?php
        }
    
        function Merge()
        {
            echo "Merge";
        }
    ?>
