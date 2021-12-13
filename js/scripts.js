function verif(champ1, champ2) {
	let c1=document.getElementById(champ1);
	let c2=document.getElementById(champ2);
	if (c1.value==c2.value)
	{
		c1.style.outline="2px solid green";
		c2.style.outline="2px solid green";
	}
	else 
	{
		c1.style.outline="2px solid red";
		c2.style.outline="2px solid red";
	}
}