<?php
# Include script to make a database connection
include("connect.php");
include("menuBar.html");

if (!empty($_GET['genre_name']) || !empty($_GET['monthV']) || !empty($_GET['year']) || !empty($_GET['place_of_origin']) || !empty($_GET["notable_bands"]) || !empty($_GET["comments"])){

$genre_name         = $_GET['genre_name'];
$monthV             = $_GET['monthV'];
$yearV              = $_GET['yearV'];
$place_of_origin    = $_GET['place_of_origin'];
$place_of_origins   = implode(', ', $place_of_origin);
$notable_band       = $_GET['notable_bands'];
$notable_bands      = implode(', ', $notable_band);
$comments           = $_GET["comments"];

# Insert into the database
$query = "INSERT INTO genres (genre_name,monthV,yearV,place_of_origin,notable_bands,comments) VALUES ('$genre_name','$monthV','$yearV','$place_of_origins','$notable_bands','$comments')";
if (mysqli_query($conn, $query)) {
    echo "New record created successfully !";
    } else {
         echo "Error inserting record: " . $conn->error;
    }
 }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Genre</title>

</head>
<body>
    <h1>Create Genres </h1>
        <form name="createGenre" method="get" action="createGenre.php" onsubmit="return validateForm()" required>
            Name: <input type="text" name="genre_name"><br><br/>
            <label for="monthV" class="required">   Month of Origin: </label>
        <select class="form-select" id="monthV" name="monthV" required>
            <option value="">month</option>
            <option value="Not Specified">Not Specified</option>
            <option value="January">January</option>
            <option value="February">February</option>
            <option value="March">March</option>
            <option value="April">April</option>
            <option value="May">May</option>
            <option value="June">June</option>
            <option value="July">July</option>
            <option value="August">August</option>
            <option value="September">September</option>
            <option value="October">October</option>
            <option value="November">November</option>
            <option value="December">December</option>
        </select><br><br>

        <label for="yearV" class="required"> Year of Origin: </label>
        <select class="form-select" id="yearV" name="yearV" required>
            <option value="">year</option>
            <option value="1940">1940</option>
            <option value="1941">1941</option>
            <option value="1942">1942</option>
            <option value="1943">1943</option>
            <option value="1944">1944</option>
            <option value="1945">1945</option>
            <option value="1946">1946</option>
            <option value="1947">1947</option>
            <option value="1948">1948</option>
            <option value="1949">1949</option>
            <option value="1950">1950</option>
            <option value="1951">1951</option>
            <option value="1952">1952</option>
            <option value="1953">1953</option>
            <option value="1954">1954</option>
            <option value="1955">1955</option>
            <option value="1956">1956</option>
            <option value="1957">1957</option>
            <option value="1958">1958</option>
            <option value="1959">1959</option>
            <option value="1960">1960</option>
            <option value="1961">1961</option>
            <option value="1962">1962</option>
            <option value="1963">1963</option>
            <option value="1964">1964</option>
            <option value="1965">1965</option>
            <option value="1966">1966</option>
            <option value="1967">1967</option>
            <option value="1968">1968</option>
            <option value="1969">1969</option>
            <option value="1970">1970</option>
            <option value="1971">1971</option>
            <option value="1972">1972</option>
            <option value="1973">1973</option>
            <option value="1974">1974</option>
            <option value="1975">1975</option>
            <option value="1976">1976</option>
            <option value="1977">1977</option>
            <option value="1978">1978</option>
            <option value="1979">1979</option>
            <option value="1980">1980</option>
            <option value="1981">1981</option>
            <option value="1982">1982</option>
            <option value="1983">1983</option>
            <option value="1984">1984</option>
            <option value="1985">1985</option>
            <option value="1986">1986</option>
            <option value="1987">1987</option>
            <option value="1988">1988</option>
            <option value="1989">1989</option>
            <option value="1990">1990</option>
            <option value="1991">1991</option>
            <option value="1992">1992</option>
            <option value="1993">1993</option>
            <option value="1994">1994</option>
            <option value="1995">1995</option>
            <option value="1996">1996</option>
            <option value="1997">1997</option>
            <option value="1998">1998</option>
            <option value="1999">1999</option>
            <option value="2000">2000</option>
            <option value="2001">2001</option>
            <option value="2002">2002</option>
            <option value="2003">2003</option>
            <option value="2004">2004</option>
            <option value="2005">2005</option>
            <option value="2006">2006</option>
            <option value="2007">2007</option>
            <option value="2008">2008</option>
            <option value="2009">2009</option>
            <option value="2010">2010</option>
            <option value="2011">2011</option>
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
            <option value="2016">2016</option>
            <option value="2017">2017</option>
            <option value="2018">2018</option>
            <option value="2019">2019</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
        </select>
        <br/>  <br/>

       <label>Place of Origin</label> <button type="button"  onclick="addEntry();"> Add Another Location </button>
            <br/> <br/>
            <div id="place_of_origin">
                <div class="form-group">
                    <input type="text" name="place_of_origin[]" placeholder="Enter here..." class="form-control" required="required"/>
                </div>
            </div> 
            <br/>


             <label>Notable Bands</label> <button type="button"  onclick="addFn();"> Add Another Band </button>
            <br/> <br/>
            <div id="notable_bands">
                <div class="form-group">
                    <input type="text" name="notable_bands[]" placeholder="Enter here..." class="form-control" required="required"/>
                </div>
            </div>

        
    </div>
    <script>
        function addFn() {
          var entry="<input type='text' name='notable_bands[]' placeholder='Enter here...' class='form-control' required='required'/>";
            var element=document.createElement("div");
            element.setAttribute('class', 'form-group');
            element.innerHTML=entry;
            document.getElementById('notable_bands').appendChild(element);
        }

        function addEntry(){
            var entry="<input type='text' name='place_of_origin[]' placeholder='Enter here...' class='form-control' required='required'/>";
            var element=document.createElement("div");
            element.setAttribute('class', 'form-group');
            element.innerHTML=entry;
            document.getElementById('place_of_origin').appendChild(element);
    }
    </script>


            Comments: <textarea name="comments"></textarea><br><br/>
            <input type="submit" name="save" value="submit" >
        </form>
    </body>
</html>
