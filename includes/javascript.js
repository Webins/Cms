const input = document.getElementById("input");

if(input != null){
    input.addEventListener("keydown", (e) =>{
        if(e.key != null){
            document.getElementById("display-msg").style.display="none";
        }
    })
}

const img_input = document.getElementById("img-input");
if(img_input){
    const label = document.getElementById("label-img");
    const span = document.createElement("span");
    const i = document.createElement("i");
    img_input.addEventListener("change", (e) => {
       label.textContent="";
       i.className="fas fa-check";
       span.textContent= img_input.value+" ";
       span.className="text-info";
       span.append(i);
       label.append(span);  
    });
}