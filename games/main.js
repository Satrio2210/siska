// seleksi
const pilihan = document.querySelectorAll("li img");
const main = document.querySelector('.main');
let i = 0,
    j = 0;
const nama = prompt('nama anda?');
const userName = document.getElementsByClassName('User')[0];
userName.innerHTML = nama;

pilihan.forEach(function(e){
e.addEventListener('click', function(){
    // user
    const src = e.attributes.src.nodeValue;
    const pilihanUser = src.split('.');
    const user = document.querySelector(".user-main img");
    user.setAttribute('src',pilihanUser[0]+'.png');
    user.style.transform = 'rotate(90deg) scaleX(-1)';

    // Comp
    const pilihanComp = acakPilih();
    const comp = document.querySelector(".comp-main img");
    comp.setAttribute('src','img/'+pilihanComp+'.png');
    comp.style.transform = 'rotate(-90deg) scaleX(1)';

    // hasil
    const pilihanUser1 = pilihanUser[0].split('/');
    console.log(pilihanUser1);
    const hasil = hasilNya(pilihanUser1[1],pilihanComp);
    const result = document.getElementsByClassName('result')[0];
    const userScore = document.getElementsByClassName('user-score')[0];
    const compScore = document.getElementsByClassName('comp-score')[0];
    
    result.innerHTML = hasil;
    if(hasil=="MENANG"){
        i++;
        userScore.innerHTML = i;
    }
    
    if(hasil=="KALAH"){
        j++;
        compScore.innerHTML = j;
    }

})
});

//  function random pilihan komputer
function acakPilih(){
    let acak = Math.random();
    if(acak <0.34){
        return 'Batu';
    
    }else if(acak>=0.34&&acak <0.67){
       return 'Gunting';
    }else{
        return 'Kertas';
    }
}

// Hasil
function hasilNya(a,b){
    if(a==b) return 'SERI';
    
    if(a=='Batu') return (b=='Gunting') ? 'MENANG' : 'KALAH';
    
    if(a=='Gunting') return (b=='Kertas')? 'MENANG' : 'KALAH';
    
    if(a=='Kertas') return (b=='Batu')?'MENANG' : 'KALAH';
    
}