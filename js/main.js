
const DVD = `<div id="DVD">
            <label for="size">Size (MB)<span class="required">*</span></label>
            <input type="number" id="size" name="size" step=".01" placeholder="in MB"><br><br>
            <p>Please provide DVD's size in MB</p>
        </div>`
const BOOK = `<div id="Book">
            <label for="weight">Weight (Kg)<span class="required">*</span></label>
            <input type="number" id="weight" name="weight" step=".01" placeholder="in KG"><br><br>
            <p>Please provide book's weight in KG</p>
        </div>`
const FURNITURE = `<div id="Furniture">
                <label for="height">Height (CM)<span class="required">*</span></label>
                <input type="number" id="height" name="height" step=".01" placeholder="in CM"><br><br>
                
                <label for="width">Width (CM)<span class="required">*</span></label>
                <input type="number" id="width" name="width" step=".01" placeholder="in CM"><br><br>
                
                <label for="length">Length (CM)<span class="required">*</span></label>
                <input type="number" id="length" name="length" step=".01" placeholder="in CM"><br><br>
                
                
                <p>Please provide a height, width, length respectively in CM.<br>
                Dimensions entered will be displayed in Product list page in form of H&times;W&times;L</p>

            </div>`




function notify(field, message) {
    /*  args: field => string 
            message => string
        function => generate an alert to the end user 
        indicate what is the error that occured.
        return => string containing html content
    */
    return `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Invalid ${field}!</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`
}

dict = {
    "DVD": DVD,
    "BOOK": BOOK,
    "FURNITURE": FURNITURE
}



function display() {
    /* 
        function => put the appropriate input field 
        for the product type choosen by the user
    */
    var x = document.getElementById("productType").value;
    document.getElementById('view1').innerHTML = dict[x];
}



function pre(){
    /* 
        function => prevent the form value to be sent to php
    */
    event.preventDefault();
}

function validateForm()
{
    /* 
        function => responsible to check every input field
        empty? is logic correct? malicious ?
        if one of these three questions is yes 
        the function will prevent form to be submitted to php file
        and generate a notification indicate where and what 
        error occured,
        else the function will return a true value and submit the form
    */

    var sku = document.forms["form1"]["p_sku"].value;
    var name = document.forms["form1"]["p_name"].value;
    var price = document.forms["form1"]["p_price"].value;


    if (sku == '') 
    {
        pre();
        document.getElementById('view2').innerHTML = notify("SKU", "SKU field can not be empty");
        return false;
    }
    else if (name == ''){
        pre();
        document.getElementById('view2').innerHTML = notify("Name", "Name field can not be empty");
        return false;
    }
    else if (price == '') 
    {
        pre();
        document.getElementById('view2').innerHTML = notify("Price", "Price field can not be empty");
        return false;
    }

    if (!/^[A-z0-9]+$/.test(sku) || (sku.length != 8 && sku.length != 9))
    {
        pre();
        document.getElementById('view2').innerHTML = notify("SKU", "SKU must consist of letters and/or numbers with 8 or 9 charachters");
        return false;
    }
    else if (!/^[A-z\s]+$/.test(name) || name.length < 4 || name.length > 100)
    {
        pre();
        document.getElementById('view2').innerHTML = notify("Name", 
        "Name must consist of letters(can include white space in between) length should be 4 => 100 charachters");
        return false;
    } 
    else if(price < 0.1 || price > 1000000)
    {
        pre();
        document.getElementById('view2').innerHTML = notify("Price", "Price should not be less than 0.1 or greater than 1 million");
        return false;
    } 
    
    
    /* Check if there is a type choosen */
    const sec = document.querySelector("#view1");
    if (sec.childNodes.length == 0)
    {
        pre();
        document.getElementById('view2').innerHTML = notify("Type", "Please choose a type");
        return false;
    }


    // get input tag 
    var sizeIn = document.getElementById("size");
    var weightIn = document.getElementById("weight");
    var heightIn = document.getElementById("height");
    var widthIn = document.getElementById("width");
    var lengthIn = document.getElementById("length");
    
    /* check if input with id #size is defined 
        then in case of success check if it is empty and valid.
        Same for the other input like weight, height, ...
    */
    if (sizeIn)
    {
        // in case of defined input tag -> get the value
        var size = sizeIn.value;
        if (size == '')
        {
            pre();
            document.getElementById('view2').innerHTML = notify("Size", "Please provide a size for the DVD");
            return false;
        }
        else if (size < 1 || size > 17080)
        {
            pre();
            document.getElementById('view2').innerHTML = notify("Size", "Size cannot be less than 1 or greater than 17080");
            return false;
        }
    }
    else if (weightIn)
    {
        var weight = weightIn.value;
        if (weight == '')
        {
            pre();
            document.getElementById('view2').innerHTML = notify("Weight", "Please provide a weight for the Book");
            return false;
        }
        else if (weight < 0.1 || weight > 10)
        {
            pre();
            document.getElementById('view2').innerHTML = notify("Weight", "Weight cannot be less than 0.1 or greater than 10");
            return false;
        }

    }
    else if (heightIn && widthIn && lengthIn)
    {
        var height = heightIn.value;
        var width = widthIn.value;
        var length = lengthIn.value;
        if (height == '')
        {
            pre();
            document.getElementById('view2').innerHTML = notify("Height", "Please provide a height for the Furniture");
            return false;
        }
        else if (height < 10 || height > 9999)
        {
            pre();
            document.getElementById('view2').innerHTML = notify("Height", "Height cannot be less than 10 or greater than Ten Thousand");
            return false;
        }
        
        else if (width == '')
        {
            pre();
            document.getElementById('view2').innerHTML = notify("Width", "Please provide a width for the Furniture");
            return false;
        }
        else if (width < 15 || width > 9999)
        {
            pre();
            document.getElementById('view2').innerHTML = notify("Width", "Width cannot be less than 15 or greater than Ten Thousand");
            return false;
        }
        
        else if (length == '')
        {
            pre();
            document.getElementById('view2').innerHTML = notify("Length", "Please provide a length for the Furniture");
            return false;
        }
        else if (length < 20 || length > 9999)
        {
            pre();
            document.getElementById('view2').innerHTML = notify("Length", "Length cannot be less than 20 or greater than Ten Thousand");
            return false;
        }
    }
    
    return true;
    
}




