<style>
    .returntrans {
        height: auto;
        color: #eee;
        position: absolute;
        color: black;

    }
 
    .bordermalupet {
        padding: 1rem;
        position: relative;
        background: linear-gradient(to right, rgb(245, 32, 35));
        padding: 3px;
        z-index: 3;

    }

    .return-container {
        border: none;
        margin: 0.15em;
    }

    #option {
        margin-right: auto;
        height: 60%;
        font-size: 15px;
        padding: 3px;
    }

    .optionsreturn {
        display: flex;
        align-items: center;

    }
    .returntrans{
        margin-top: 0;
    }
    /* //receipt return transc */
    .recieptreturn {
        border: 2px solid #222;
        width: 80vw;
        height: 90vh;
        display: flex;
        flex-direction: column;
        padding:5em;
        box-sizing: border-box;


    }
    .recieptreturn table{
        margin-top: .5em;
        border-collapse: collapse;
    }
    .recieptreturn td,th{
        padding: 1em;
        font-size: 15px;

    }

    .modalasi{
        box-sizing: border-box;
        padding:1em;
        width: 100%;
        height: 100%;
        overflow: auto;
    }
    .modalasi table{
        margin-bottom: 3em;
    }
    .recieptreturn th,.modalasi th{
        background-color: #222;
        color: #eee;
    }
    .modalasi td{
        font-size: 14px;
    }
</style>

<main class="returntrans">

    <div class="umay"></div>
    <div class="bordermalupet">
        <div class="reservations-container return-container">
            <div class="filter-reserves-container">
                <h4 style="color:white;">Filter for user who borrowed book and have unsettle penalties</h4>
                <form class='findcontainer findretcontainer'>
                    <input type="search" class="filterusers filterusersret" id="filterdata" autocomplete="off" placeholder="search by id...">
                </form>
                <hr>
                <p>member list ..</p>
                <div class="list-items-reservuser listwhoborrow"></div>
            </div>
            <div class="resultcontainer return-container">
                <div class="userdesc">
                    <img class="editimgr" style="margin:2em;height:100px;width:130px;border-radius:10px;" src='usersprofileimg/profiledefault.jpg'>
                    <h1 class="profiler">Profile</h1>

                </div>
                <div class="reserve-container transreport">NO data Found YEt...</div>
                
            </div>

        </div>
    </div>
</main>
<!-- modal for addselecteditem RETURN TRANSACTION  -->
<style>
    .addselectedmodalcontainer{
    position: fixed;
    background: rgba(0,0,0,0.4);
    top: 0;
    left: 0;
    right:0;
    bottom:0;
    z-index:100;
    display:grid;
    place-items: center;
    transform: scale(0);
        transition: transform 200ms;
    }
    .transactionitems{
        width: 50%;
        height: 70%;
        background: white;
    }
    
    .tabledataoutput{
        position: fixed;
    background:whitesmoke;
    top: 0;
    left: 0;
    right:0;
    bottom:0;
    z-index:100;
    display:grid;
    place-items: center;
    transform: scale(0);
        transition: transform 200ms;
    }
    .addselectshow{
        transform: scale(1);
    }
    #rectable ,#rectable td,#rectable th{
        border: 1px solid black;
  border-collapse: collapse;
    }
</style>
<div class="addselectedmodalcontainer">
    <div class="transactionitems">
       
    </div>
</div>
    <div class="tabledataoutput">
        
    </div>

<script>
    //variable declarations 
    const userbucket = document.querySelector(".listwhoborrow");
    const userreportscontainer = document.querySelector(".transreport");
    const profiler = document.querySelector(".profiler");
    const editimgr = document.querySelector(".editimgr");
    const findretcontainer = document.querySelector(".findretcontainer");
    const filterusersret = document.querySelector(".filterusersret");
    const transactionitems = document.querySelector(".transactionitems");
    const addselectedmodalcontainer = document.querySelector(".addselectedmodalcontainer");
    const adminsid = document.querySelector(".userid").dataset.userid;
    const tabledataoutput = document.querySelector(".tabledataoutput");
    //cancel button in printable report
    function cancelinprint(e) {
        tabledataoutput.classList.remove("addselectshow");
        addselectedmodalcontainer.classList.remove("addselectshow");
        transactionitems.innerHTML = "";
        tabledataoutput.innerHTML = "";

        //refresh the transaction record
       let id = e.currentTarget.dataset.useridtransNo;
  
                 console.log(id);
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "methods/filterusertransreport.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status == 200) {
                const res = xhr.responseText;
                userreportscontainer.innerHTML = res;
                const stat = document.querySelector(".datasr");
                if (stat.dataset.statusr = "off") 
                {
              
                profiler.innerHTML = "Profile";
                editimgr.src = "usersprofileimg/profiledefault.jpg";
                    
                }

            } else {
                console.log("failed");
            }
        }
        xhr.send(`userid=${id}`);


    }
    //processing Transaction 
    function selectproccesstransacs(e) {

     const typeotrans = document.querySelector("#option");
    console.log(typeotrans.value);
    const checkbox = Array.from(document.querySelectorAll(".selectitemtransnoADRT"));
    console.log(checkbox);
    console.log(checkbox.length);
 let id = parseInt(e.currentTarget.dataset.useridtrans);
 console.log(id);
    //get all checked items put it in array
    let newarray = checkbox.reduce((total, item) => {
            total.push((item.value));
        return total;
    }, [])

    if (newarray.length > 0) {
        console.log(checkbox.length + "true");
        console.log(newarray ,"process");  
        const params = `selecteditemstobeprocess=${JSON.stringify(newarray)}&userid=${id}&typeoftrans=${typeotrans.value}&adminid=${adminsid}`;
        const xhrs = new XMLHttpRequest();
        xhrs.open("POST", "methods/typeoftransaction.php", true);

        xhrs.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhrs.onload = function() {
            if (xhrs.status == 200) {

                const res = xhrs.responseText;
           
             
                tabledataoutput.innerHTML = res;
                tabledataoutput.classList.add("addselectshow");
            } else {
                console.log("failed");
            }
            showuserborrow();
        }
        xhrs.send(params);

}

    }
    //removing selected in modal RT 
    function removelistRTMODAL() {

                    const checkbox = Array.from(document.querySelectorAll(".selectitemtransnoADRT"));
                    console.log(checkbox);
                    console.log(checkbox.length);
                    //get all checked items put it in array
                    checkbox.forEach( item => {
                        if (item.checked) {
                            item.parentElement.parentElement.remove();
                        }
                     
                    })
            }
// close modal selected items for transaction modal
    function canceladdselected() {
        addselectedmodalcontainer.classList.remove("addselectshow");
        transactionitems.innerHTML = "";
    }
    //selected items for transaction modal

                function selectaddshow(e) {
                    const typeotrans = document.querySelector("#option");
    
                    console.log(typeotrans.value);
                    const checkbox = Array.from(document.querySelectorAll(".selectitemtransno"));
                    console.log(checkbox);
                    console.log(checkbox.length);
                 let id = parseInt(e.currentTarget.dataset.useridtrans);
                 console.log(id);
                    //get all checked items put it in array
                    let newarray = checkbox.reduce((total, item) => {
                        if (item.checked) {
                            total.push((item.value));
                        }
                        return total;
                    }, [])

                    if (newarray.length > 0) {
                        console.log(checkbox.length + "true");
                        console.log(newarray ,"adddselected");
                        const params = `selecteditemstobeprocess=${JSON.stringify(newarray)}&userid=${id}&typeoftrans=${typeotrans.value}`;
                        const xhrs = new XMLHttpRequest();

                        xhrs.open("POST", "methods/addselectedRT.php", true);

                        xhrs.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                        xhrs.onload = function() {
                            if (xhrs.status == 200) {

                                const res = xhrs.responseText;
                                transactionitems.innerHTML = res;
                                const trigger = document.querySelector("#triger");
                                console.log(res);
                                console.log(trigger.dataset.trigger);
                                if(trigger.dataset.trigger > 0){
                                    alert(trigger.textContent);
                                    trigger.remove();
                                    
                                   
                                }else{
                                    addselectedmodalcontainer.classList.add("addselectshow");
                                }
                               

                            } else {
                                console.log("failed");
                            }
                        }
                        xhrs.send(params);

                }else{
                    alert("Please Select an Item!")
                }

            }
    //show the users with borrowed books and unpaid penalties updating every 500ms hahahaha!
    function showuserborrow() {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "methods/getuserhavereserves.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status == 200) {
                const res = xhr.responseText;
                    userbucket.innerHTML = res;

            } else {
                console.log("failed");
            }
        }
        xhr.send(`table=borrowtran&getfield=DateBorrowed`);
    }

  
        showuserborrow();
  


    //click function for list of users found in borrowed books and unpaid penalties
    function uniquserbtran(e) {
       
        const targetedid = e.currentTarget.dataset.userid;
        const targetname = e.currentTarget.innerText;
        const imgtarget = e.currentTarget.children[0].dataset.imgsrc;
        
       
        console.log(targetedid);
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "methods/filterusertransreport.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status == 200) {
                const res = xhr.responseText;
                    userreportscontainer.innerHTML = res;
                profiler.innerHTML = targetname;
                editimgr.src = imgtarget;

            } else {
                console.log("failed");
            }
        }
        xhr.send(`userid=${targetedid}`);

    }
    //search in return transaction facility for finding users transactions hahahahahahahahahahaha!!!   
    findretcontainer.addEventListener('submit', srchretsumbit);
    filterusersret.addEventListener('keyup', searchretkey);

    //key event function for search in ret transaction
    function searchretkey(eve) {
        if (filterusersret.value.length == '') {

         
                showuserborrow();
         

        }else{
            srchretsumbit(e)            
        }
    }
    //submit event function for search in ret transaction
    function srchretsumbit(e) {

        e.preventDefault();
        seachval = filterusersret.value;

        if (seachval.length > 0) {
           
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "methods/searchuserforResandtrans.php", true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status == 200) {
                        const res = xhr.responseText;
                        userbucket.innerHTML = res;
                    } else {
                        console.log("failed");
                    }
                }
                xhr.send(`searchthisuser=${seachval}&table=borrowtran`);
          
        } else {
       
        }


    }
</script>