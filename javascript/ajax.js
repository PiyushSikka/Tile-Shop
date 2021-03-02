//Revision History 

//Dev             Date                  Desc
//PS(2013552)   2020-10-12      Created Ajex js file
const XHR_READY = 4;
const XHR_OK = 200;

//error handling(mandatory)
function handleError(error)
{
    alert("Error Occured: ", error);
}

function searchPurchases()
{
    try
    {
        //we need a variable to perform an AJAX request
        var xhr = getXmlHttpRequest();
        xhr.onreadystatechange = function()
        {
            //AJAX ready states
            //0: unitialized
            //1: Loading
            //2: Loaded
            //3: Interactive
            //4: Completed
            if(xhr.readyState == XHR_READY && xhr.status == XHR_OK)
            {
                //response can be XML
                //xhr.responseXML
                //response can be HTML
                //xhr.responseText
                document.getElementById('searchResults').innerHTML = xhr.responseText;
            }
        }
        xhr.open("POST", 'searchPurchases.php');
        //specify that the request does not contain binary data
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        
        var searchQuery = document.getElementById('searchQuery').value;
        xhr.send('searchQuery=' + searchQuery);
    }
    catch(error)
    {
        handleError(error);
    }
}

function getXmlHttpRequest()
{
    try
    {
        var xhr = null;
        if(window.XMLHttpRequest)   //for all browsers except Internet Explorer
        {
            xhr = new XMLHttpRequest();
        }
        else
        {
            //code for Internet Explorer
            if(window.ActiveXObject)
            {
                try
                {
                    xhr = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch(error)
                {
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                }
            }
            else
            {
                alert("Your browser does not support XMLHTTPRequest objects");
            }
        }
        return xhr;
    }
    catch(error)
    {
        handleError(error);
    }
}



