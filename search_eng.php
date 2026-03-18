<?php   require_once "arrays.php";    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Portal</title>
    <style>
        :root {
            --primary: #2563eb;
            --bg: #f8fafc;
            --text: #1e293b;
            --highlight: #fef08a; /* Soft yellow for matches */
        }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.6;
            padding: 2rem;
            
        }

        .search-container {
            max-width: 600px;
            margin: 0 auto 3rem auto;
            text-align: center;
            position:  -webkit-sticky;
            top: 1px;
        }

        /* The Search Form */
        .search-form {
            display: flex;
            gap: 10px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            background: white;
            padding: 8px;
            border-radius: 12px;
            width: fit-content;
            
        }

        .search-input {
            flex-grow: 1;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            outline: none;
            font-size: 1rem;
        }

        .search-input:focus {
            border-color: var(--primary);
        }

        .search-button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: opacity 0.2s;
        }

        .search-button:hover {
            opacity: 0.9;
        }

        /* Results Grid */
        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Result Cards */
        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card-title {
            margin-top: 0;
            font-size: 1.25rem;
            color: var(--primary);
        }

        /* The Highlight Class */
        .highlight {
            background-color: var(--highlight);
            padding: 0 2px;
            border-radius: 2px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="search-container">
        <h1>Find Content</h1>
        <form action="search_eng.php" method="GET" class="search-form">
            <input type="text" name="query" class="search-input" placeholder="Search for keywords..." value="<?php echo $_GET['query']??false; ?>">
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>

    <main class="results-grid">
    <?php
    //<span class="highlight">PHP</span> 
   if($search !==false && isset($found)){
    echo "time taken is ".$stop - $start ."<br>";

$i=0;

foreach($found as $printie){
if(strpos($printie['descr'],"<b class='highlight'>") === false && strpos($printie['name'],"<b class='highlight'>") === false  ){ continue;} 
echo "
       <article class='card'>
           <h2 class='card-title'>".(++$i).":".$printie['name']."</h2>
            <p class='card-description'>
               ".$printie['descr']."
            </p>
        </article>
        ";
}
}else{
echo "TRY SEARCH SOMETHING NEW";
  
}
        ?>
        
    </main>

</body>
</html>
