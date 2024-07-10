(function () {
    "use strict";
    /*---------------------------------------------------------------------
        Fieldset
    -----------------------------------------------------------------------*/
    
    let currentTab =0;
    const ActiveTab=(n)=>{
        if(n==0){
            document.getElementById("infoPersonal").classList.add("active");
            document.getElementById("infoPersonal").classList.remove("done");
            document.getElementById("infoFamiliar").classList.remove("done");
            document.getElementById("infoFamiliar").classList.remove("active"); 
        }
        if(n==1){
            document.getElementById("infoPersonal").classList.add("done");
            document.getElementById("infoFamiliar").classList.add("active");
            document.getElementById("infoFamiliar").classList.remove("done");
            document.getElementById("infoPregPersonal").classList.remove("active");
            document.getElementById("infoPregPersonal").classList.remove("done");
            document.getElementById("infoEducacion").classList.remove("done");
            document.getElementById("infoEducacion").classList.remove("active");

        }
        if(n==2){
            document.getElementById("infoPersonal").classList.add("done");
            document.getElementById("infoFamiliar").classList.add("done");
            document.getElementById("infoPregPersonal").classList.add("active");
            document.getElementById("infoPregPersonal").classList.remove("done");
            document.getElementById("infoEducacion").classList.remove("done");
            document.getElementById("infoEducacion").classList.remove("active");
        }
        if(n==3){
            document.getElementById("infoPersonal").classList.add("done");
            document.getElementById("infoFamiliar").classList.add("done");
            document.getElementById("infoPregPersonal").classList.add("done");
            document.getElementById("infoEducacion").classList.add("active");
            document.getElementById("infoEducacion").classList.remove("done");
            document.getElementById("experienciaLaboral").classList.remove("done");
            document.getElementById("experienciaLaboral").classList.remove("active");
            document.getElementById("conocimientoEmpresa").classList.remove("done");
        }
        if(n==4){
            document.getElementById("infoEducacion").classList.add("done");
            document.getElementById("experienciaLaboral").classList.add("active");
            document.getElementById("experienciaLaboral").classList.remove("done");
            document.getElementById("conocimientoEmpresa").classList.remove("done");
            document.getElementById("conocimientoEmpresa").classList.remove("active");
        }
        if(n==5){
            document.getElementById("experienciaLaboral").classList.add("done");
            document.getElementById("conocimientoEmpresa").classList.add("active");
        }
    } 
    const showTab=(n)=>{
        var x = document.getElementsByTagName("fieldset");
        x[n].style.display = "block";
        console.log(n);
        ActiveTab(n);
       
    }
    const nextBtnFunction= (n) => {
        var x = document.getElementsByTagName("fieldset");
        x[currentTab].style.display = "none";
        currentTab = currentTab + n;
        showTab(currentTab);
    }
    
    const nextbtn= document.querySelectorAll('.next')
    Array.from(nextbtn, (nbtn) => {
    nbtn.addEventListener('click',function()
    {
        nextBtnFunction(1);
    })
});

// previousbutton

const prebtn= document.querySelectorAll('.previous')
    Array.from(prebtn, (pbtn) => {
    pbtn.addEventListener('click',function()
    {
        nextBtnFunction(-1);
    })
});
    
})()