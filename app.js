var trs = document.querySelectorAll(".glyphicon");
var i;
for(i=0;i<trs.length;i++)
{
    trs[i].addEventListener("click",function(e){
        alert("you have selected : "+ e.target.id);
    });
}