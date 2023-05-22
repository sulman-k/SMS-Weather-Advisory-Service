// eng OpenPad
// Written by Nabeel Hasan Naqvi (simunaqv [at] gmail [dot] com)
// Visit the support forums at http://www.engweb.org/mehfil
// This code is public domain. Redistribution and use of this code, with or without modification, is permitted.

var	isIE;
var	isGecko;
var	isSafari;
var	isKonqueror;
var	isOpera;
var	CurrentKeyboard;
var	LAlt;
var	RAlt;
var	RShift;
var	LShift;
var	LCtrl;
var	RCtrl;
var	HelpArea;
var	kbNormal=1;
var	kbShift=2;
var	kbAlt=3;
var	kbCtrl=4;
var	kbAltGr=5;
var	bToggleFlag=0;
var	CurrentKeyboardState=1;
var	currEdit=null;
var	langSel=1;
var	Iseng=1;
var	bCtrlState=0;
var	bAltState=0;
var	CurrentKeyboard;
var	Diacritics=new Array(0x0650, 0x064E,0x064B,	0x064F,	0x064D,	0x064C,	0x0651,	0x0652,	0x0670);
var	charSingleQuote=String.fromCharCode(39);
var	charDoubleQuote=String.fromCharCode(34);
var charSpace=String.fromCharCode(32);
var	ValidChars='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'+'-&=;,.[]{}|/\\'+charSingleQuote+charSpace;
function isDiacritic(c)
{
    for(i=0; i<Diacritics.length; i++)
    {
        if(c== Diacritics[i])
        {
            return true;
        }
    }
    return false;
}
function charCode(strChar)
{
    return strChar.charCodeAt(0);
}
function Key(x,	y,z	)
{
    this.normal=0;
    this.shifted=0;
    this.alt=0;
    this.id=this.normal=x;
    if(arguments.length>1)
    {
        this.shifted= y;
    }
    if(arguments.length>2)
    {
        this.alt= z;
    }
}
function KeyHelp(x,y)
{
    this.normal=x;
    this.shifted=y
}
function Keyboard()
{
    this.Keys= new Array();
    this.Shifted= new Array();
    this.AltGr=	new	Array();
    this.MultiChar=	new	Array();
    
    this.AddKey=function(ch, x, y, z)
    {
		//alert(ch+' '+x+' '+y+' '+z);
		this.Keys[ch]=new Key(x);
		
		if(arguments.length>2)
		{
			this.Shifted[ch]= y;
			//alert(this.Shifted[ch]);
		}
		
		if(arguments.length>3)
		{
			this.AltGr[ch]= z;
			//alert(this.AltGr[ch]);
		}
    }
}


var engPhonetic= new Keyboard();
engPhonetic.Keys['a']=new Key(0x0627, 0x0622, 0x0623);
engPhonetic.Keys['b']=new Key(0x0628, 0x0628, 0x202E);
engPhonetic.Keys['c']=new Key(0x0686, 0x062B, 0x202A);
engPhonetic.Keys['d']=new Key(0x062F, 0x0688);
engPhonetic.Keys['e']=new Key(0x0639, 0x0651, 0x0611);
engPhonetic.Keys['f']=new Key(0x0641, 0x64D);
engPhonetic.Keys['g']=new Key(0x06AF, 0x063A);
engPhonetic.Keys['h']=new Key(0x06BE, 0x062D, 0x0612);
engPhonetic.Keys['i']=new Key(0x06CC, 0x0670, 0x656);
engPhonetic.Keys['j']=new Key(0x062C, 0x0636);
engPhonetic.Keys['k']=new Key(0x06A9, 0x062E);
engPhonetic.Keys['l']=new Key(0x0644, 0x0628);
engPhonetic.Keys['m']=new Key(0x0645, 0x64B, 0x200F);
engPhonetic.Keys['n']=new Key(0x0646, 0x06BA, 0x202B);
engPhonetic.Keys['o']=new Key(0x06C1, 0x06C3, 0x06C2);
engPhonetic.Keys['p']=new Key(0x067E, 0x064F);
engPhonetic.Keys['q']=new Key(0x0642);
engPhonetic.Keys['r']=new Key(0x0631, 0x0691, 0x0613);
engPhonetic.Keys['s']=new Key(0x0633 , 0x0635, 0x610);
engPhonetic.Keys['t']=new Key(0x062A , 0x0679);
engPhonetic.Keys['u']=new Key(0x0626 , 0x0621);
engPhonetic.Keys['v']=new Key(0x0637, 0x0638, 0x202C);
engPhonetic.Keys['w']=new Key(0x0648, 0x0624, 0xFDFA);
engPhonetic.Keys['x']=new Key(0x0634, 0x0698, 0x202D);
engPhonetic.Keys['y']=new Key(0x06D2, 0x0601);
engPhonetic.Keys['z']=new Key(0x0632, 0x0630, 0x200E);
/*engPhonetic['0']=new Key(0x660, charCode(')'));
engPhonetic['1']=new Key(0x661, charCode('!'));
engPhonetic['2']=new Key(0x662, charCode('@'));
engPhonetic['3']=new Key(0x663, charCode('#'));
engPhonetic['4']=new Key(0x664, charCode('$'));
engPhonetic['5']=new Key(0x665, charCode('%'));
engPhonetic['6']=new Key(0x666, charCode('^'));
engPhonetic['7']=new Key(0x667, charCode('&'));
engPhonetic['8']=new Key(0x668, charCode('*'));
engPhonetic['9']=new Key(0x669, charCode('('));*/

/*engPhonetic.Keys['0']=new Key(0x0030, charCode(')'));
engPhonetic.Keys['1']=new Key(0x0031, charCode('!'));
engPhonetic.Keys['2']=new Key(0x0032, charCode('@'));
engPhonetic.Keys['3']=new Key(0x0033, charCode('#'));
engPhonetic.Keys['4']=new Key(0x0034, charCode('$'));
engPhonetic.Keys['5']=new Key(0x0035, charCode('%'));
engPhonetic.Keys['6']=new Key(0x0036, charCode('^'));
engPhonetic.Keys['7']=new Key(0x0037, charCode('&'));
engPhonetic.Keys['8']=new Key(0x0038, charCode('*'));
engPhonetic.Keys['9']=new Key(0x0039, charCode('('));*/

engPhonetic.AddKey('1', 0x0031, charCode('!'), 0x661);
engPhonetic.AddKey('2', 0x0032, charCode('@'), 0x662);
engPhonetic.AddKey('3', 0x0033, charCode('#'), 0x663);
engPhonetic.AddKey('4', 0x0034, charCode('$'), 0x664);
engPhonetic.AddKey('5', 0x0035, charCode('%'), 0x665);
engPhonetic.AddKey('6', 0x0036, charCode('^'), 0x666);
engPhonetic.AddKey('7', 0x0037, charCode('&'), 0x667);
engPhonetic.AddKey('8', 0x0038, charCode('*'), 0x668);
engPhonetic.AddKey('9', 0x0039, charCode('('), 0x669);
engPhonetic.AddKey('0', 0x0030, charCode(')'), 0x661);

engPhonetic.Keys['=']=new Key(0x0602);
engPhonetic.Keys['-']=new Key(0x002D);
engPhonetic.Keys[',']=new Key(0x060C);
//engPhonetic.Keys['.']=new Key(0x06D4);
engPhonetic.Keys['/']=new Key(0x002F);
engPhonetic.Keys['\\']=new Key(0x060E);
engPhonetic.Keys[';']=new Key(0x061B);
engPhonetic.Keys['[']=new Key(0x201C);
engPhonetic.Keys[']']=new Key(0x201D);
engPhonetic.Keys[charSingleQuote]=new Key(39);
engPhonetic.Keys['~']=new Key(0x64C); //(0x0653);
engPhonetic.Keys[' ']=new Key(32);
engPhonetic.Keys['<']=new Key(0x064E);
engPhonetic.Keys['�']=new Key(0x0657);

engPhonetic.Shifted['!']=charCode('!');
engPhonetic.Shifted['@']=0x0600;
engPhonetic.Shifted['#']=0x0654;
engPhonetic.Shifted['$']=0x0655;
engPhonetic.Shifted['%']=0x060F;
engPhonetic.Shifted['^']=0x0652;
engPhonetic.Shifted['~']=0x064C; 
//engPhonetic.Shifted['&']=0x00BB;
engPhonetic.Shifted['*']=0x064C;
engPhonetic.Shifted['(']=0x0029;
engPhonetic.Shifted[')']=0x0028;

engPhonetic.Shifted['+']=0x0614;
engPhonetic.Shifted['_']=0x0640;

engPhonetic.Shifted['>']=0x0650; 
engPhonetic.Shifted['<']=0x064E; 
engPhonetic.Shifted['?']=0x061F; 
engPhonetic.Shifted['|']=0x0603; 
engPhonetic.Shifted['{']=0x2018; 
engPhonetic.Shifted['}']=0x2019; 
engPhonetic.Shifted[charDoubleQuote]=0x0022; 
engPhonetic.Shifted['~']=0x0653;
engPhonetic.Shifted[':']=0x003A; 
engPhonetic.Shifted[' ']=0x200C; 

engPhonetic.AltGr['[']=0x201C; 
engPhonetic.AltGr[']']=0x201D; 
engPhonetic.AltGr['{']=0x2018; 
engPhonetic.AltGr['}']=0x2019; 

var	KeyMaps= new Array();
var	Keypads=new	Array();
var	langArray=new Array();
function raiseButton(evt)
{
    evt	= (evt)	? evt :	(window.event) ? event : null;
    if(evt.srcElement)
    {
        var	el = evt.srcElement;
        className =	el.className;
        if (className == 'btnFlat' || className	== 'btnLowered')
        {
            el.className = 'btnRaised';
        }
        if (className == 'btnSysFlat' || className == 'btnSysLowered')
        {
            if((evt.srcElement==LShift)	|| (evt.srcElement==RShift))
            {
                if((bToggleFlag) &&	(CurrentKeyboardState==kbShift))
                {
                    return;
                }
                else
                el.className = 'btnSysRaised';
            }
            else if((evt.srcElement==LAlt) || (evt.srcElement==RAlt))
            {
                if((bToggleFlag) &&	(CurrentKeyboardState==kbAlt))
                {
                    return;
                }
                else
                el.className = 'btnSysRaised';
            }
            else
            el.className = 'btnSysRaised';
        }
    }
    else if(evt.target)
    {
        var	el = evt.target;
        className =	el.className;
        if (className == 'btnFlat' || className	== 'btnLowered')
        {
            el.className = 'btnRaised';
        }
        if (className == 'btnSysFlat' || className == 'btnSysLowered')
        {
            if((evt.target==LShift)	|| (evt.target==RShift))
            {
                if((bToggleFlag) &&	(CurrentKeyboardState==kbShift))
                {
                    return;
                }
                else
                el.className = 'btnSysRaised';
            }
            else if((evt.target==LAlt) || (evt.target==RAlt))
            {
                if((bToggleFlag) &&	(CurrentKeyboardState==kbAlt))
                {
                    return;
                }
                else
                el.className = 'btnSysRaised';
            }
            else
            el.className = 'btnSysRaised';
        }
    }
}
function normalButton(evt)
{
    evt	= (evt)	? evt :	(window.event) ? event : null;
    if(evt.srcElement)
    {
        var	el = window.event.srcElement;
        className =	el.className;
        if (className == 'btnRaised' ||	className == 'btnLowered')
        {
            el.className = 'btnFlat';
        }
        if (className == 'btnSysRaised'	|| className ==	'btnSysLowered')
        {
            if((evt.srcElement==LShift)	|| (evt.srcElement==RShift))
            {
                if((bToggleFlag) &&	(CurrentKeyboardState==kbShift))
                {
                    return;
                }
                else
                {
                    el.className = 'btnSysFlat';
                }
            }
            else if((evt.srcElement==LAlt) || (evt.srcElement==RAlt))
            {
                if((bToggleFlag) &&	(CurrentKeyboardState==kbAlt))
                {
                    return;
                }
                else
                {
                    el.className = 'btnSysFlat';
                }
            }
            else
            el.className = 'btnSysFlat';
        }
    }
    else if(evt.target)
    {
        var	el = evt.target;
        className =	el.className;
        if (className == 'btnRaised' ||	className == 'btnLowered')
        {
            el.className = 'btnFlat';
        }
        if (className == 'btnSysRaised'	|| className ==	'btnSysLowered')
        {
            if((evt.target==LShift)	|| (evt.target==RShift))
            {
                if((bToggleFlag) &&	(CurrentKeyboardState==kbShift))
                {
                    return;
                }
                else
                {
                    el.className = 'btnSysFlat';
                }
            }
            else if((evt.target==LAlt) || (evt.target==RAlt))
            {
                if((bToggleFlag) &&	(CurrentKeyboardState==kbAlt))
                {
                    return;
                }
                else
                {
                    el.className = 'btnSysFlat';
                }
            }
            else
            el.className = 'btnSysFlat';
        }
    }
}
function lowerButton(evt)
{
    evt	= (evt)	? evt :	(window.event) ? event : null;
    if(evt.srcElement)
    {
        var	el = window.event.srcElement;
        className =	el.className;
        if (className == 'btnFlat' || className	== 'btnRaised')
        {
            el.className = 'btnLowered';
        }
        if (className == 'btnSysFlat' || className == 'btnSysRaised')
        {
            el.className = 'btnSysLowered';
        }
    }
    else if(evt.target)
    {
        var	el = evt.target;
        className =	el.className;
        if (className == 'btnFlat' || className	== 'btnRaised')
        {
            el.className = 'btnLowered';
        }
        if (className == 'btnSysFlat' || className == 'btnSysRaised')
        {
            el.className = 'btnSysLowered';
        }
    }
}

function UpdateKeypad(kbState)
{
    var	sId;
    switch(kbState)
    {
        case kbNormal:
			for(key	in Keypads)
			{
                //console.info(JSON.stringify(CurrentKeyboard));
				if(CurrentKeyboard.Keys[Keypads[key].id])
				{
					if (document.all)
					Keypads[key].innerText=String.fromCharCode(CurrentKeyboard.Keys[Keypads[key].id].normal);
					else if(!document.all && document.getElementById)
					{
						if (isDiacritic(CurrentKeyboard.Keys[Keypads[key].id].normal))
						Keypads[key].innerHTML=String.fromCharCode(0x0627)+String.fromCharCode(CurrentKeyboard.Keys[Keypads[key].id].normal);
						else
						Keypads[key].innerHTML=String.fromCharCode(CurrentKeyboard.Keys[Keypads[key].id].normal);
					}
				}
			}
        break;
			case kbShift:
			for(key	in Keypads)
			{
				sId= Keypads[key].id;
				if (!sId) return;
				sId= sId.toUpperCase(sId);
				if(CurrentKeyboard.Keys[Keypads[key].id])
				{
					if (document.all)
					{
						if (CurrentKeyboard.MultiChar)
						{
							if (isAlpha(Keypads[key].id))
							{
								if (CurrentKeyboard.MultiChar[sId])
								{
									Keypads[key].innerText=CurrentKeyboard.MultiChar[sId];
									continue;
								}
							}
						}
						if(CurrentKeyboard.Keys[Keypads[key].id].shifted)
						{
							Keypads[key].innerText=String.fromCharCode(CurrentKeyboard.Keys[Keypads[key].id].shifted);
						}
						else
						Keypads[key].innerText=' ';
					}
					else if	(!document.all && document.getElementById)
					{
						if (CurrentKeyboard.MultiChar)
						{
							if (isAlpha(Keypads[key].id))
							{
								if (CurrentKeyboard.MultiChar[sId])
								{
									Keypads[key].innerHTML=CurrentKeyboard.MultiChar[sId];
									continue;
								}
							}
						}
						if(CurrentKeyboard.Keys[Keypads[key].id].shifted)
						{
							if (isDiacritic(CurrentKeyboard.Keys[Keypads[key].id].shifted))
							Keypads[key].innerHTML=String.fromCharCode(0x0627)+String.fromCharCode(CurrentKeyboard.Keys[Keypads[key].id].shifted);
							else
							Keypads[key].innerHTML=String.fromCharCode(CurrentKeyboard.Keys[Keypads[key].id].shifted);
						}
						else
						Keypads[key].innerHTML='�';
					}
				}
			}
			break;
        case kbAlt:
			for(key	in Keypads)
			{
				if(CurrentKeyboard.Keys[Keypads[key].id])
				{
					if (document.all)
					{
						if(CurrentKeyboard.Keys[Keypads[key].id].alt)
						{
							Keypads[key].innerText=String.fromCharCode(CurrentKeyboard.Keys[Keypads[key].id].alt);
						}
						else
						Keypads[key].innerText=' ';
					}
					else if	(!document.all && document.getElementById)
					{
						if(CurrentKeyboard.Keys[Keypads[key].id].alt)
						{
							if (isDiacritic(CurrentKeyboard.Keys[Keypads[key].id].alt))
							Keypads[key].innerHTML=String.fromCharCode(0x0627)+String.fromCharCode(CurrentKeyboard.Keys[Keypads[key].id].alt);
							else
							Keypads[key].innerHTML=String.fromCharCode(CurrentKeyboard.Keys[Keypads[key].id].alt);
						}
						else
						Keypads[key].innerHTML='�';
					}
				}
			}
			break;
    }
}

function ToggleShift()
{
    ToggleKeyboard(kbShift);
}
function ToggleAlt()
{
    ToggleKeyboard(kbAlt);
}
function ToggleAltGr()
{
    ToggleKeyboard(kbAltGr);
}
function ToggleKeyboard(ToggleKey)
{
    bToggleFlag=!bToggleFlag
    if(bToggleFlag)
    {
        if(ToggleKey==kbShift)
        {
            RShift.className='btnSysLowered';
            LShift.className='btnSysLowered';
            CurrentKeyboardState=kbShift;
            UpdateKeypad(kbShift);
        }
        else if(ToggleKey==kbAlt)
        {
            LAlt.className='btnSysLowered';
            RAlt.className='btnSysLowered';
            CurrentKeyboardState=kbAlt;
            UpdateKeypad(kbAlt);
        }
    }
    else
    {
        if(CurrentKeyboardState	== kbShift)
        {
            RShift.className='btnSysFlat';
            LShift.className='btnSysFlat';
        }
        else if(CurrentKeyboardState ==	kbAlt)
        {
            LAlt.className='btnSysFlat';
            RAlt.className='btnSysFlat';
        }
        CurrentKeyboardState = kbNormal;
        UpdateKeypad(kbNormal);
    }
}
function isValidChar(sChar)
{
    if(ValidChars.indexOf(sChar)>=0)
    {
        return true;
    }
    return false;
}
function processKeyup(evt)
{
    alert('test');
    if (!langArray[currEdit.id]) return;
    evt	= (evt)	? evt :	((event) ? event : null);
    if (evt)
    {
        var	charCode = (evt.charCode) ?	evt.charCode : evt.keyCode;
        if(charCode	== 17)
        {
            CurrentKeyboardState = kbNormal;
        }
    }
}
function Downkeys(evt)
{
    evt	= (evt)	? evt :	(window.event) ? event : null;
    if(evt)
    {
        if(document.all)
        {
            if(evt.shiftKey	)
            {
                RShift.className='btnSysLowered';
                LShift.className='btnSysLowered';
                CurrentKeyboardState=kbShift;
                UpdateKeypad(kbShift);
            }
            else if(evt.ctrlKey	&& evt.altKey)
            {
                RCtrl.className='btnSysLowered';
                LCtrl.className='btnSysLowered';
                RAlt.className='btnSysLowered';
                LAlt.className='btnSysLowered';
                CurrentKeyboardState=kbAlt;
                UpdateKeypad(kbAlt);
            }
            else if(evt.ctrlKey)
            {
                CurrentKeyboardState=kbCtrl;
            }
        }
        else if(!document.all && document.getElementById)
        {
            if(evt.ctrlKey)
            {
                if(	evt.shiftKey)
                {
                    RCtrl.className='btnSysLowered';
                    LCtrl.className='btnSysLowered';
                    RShift.className='btnSysLowered';
                    LShift.className='btnSysLowered';
                    CurrentKeyboardState=kbAlt;
                    UpdateKeypad(kbAlt);
                }
                else
                {
                    CurrentKeyboardState=kbCtrl;
                }
            }
            else if(evt.shiftKey )
            {
                RShift.className='btnSysLowered';
                LShift.className='btnSysLowered';
                CurrentKeyboardState=kbShift;
                UpdateKeypad(kbShift);
            }
        }
    }
}
function Upkeys(evt)
{
    evt	= (evt)	? evt :	(window.event) ? event : null;
    var	charCode = (evt.charCode) ?	evt.charCode : evt.keyCode;
    if(evt)
    {
        if (CurrentKeyboardState ==	kbCtrl)
        {
            CurrentKeyboardState = kbNormal;
        }
        if(CurrentKeyboardState	== kbShift)
        {
            if(!evt.shiftKey)
            {
                RShift.className='btnSysFlat';
                LShift.className='btnSysFlat';
                CurrentKeyboardState = kbNormal;
                UpdateKeypad(kbNormal);
            }
        }
        if(CurrentKeyboardState	== kbAlt)
        {
            if(document.all)
            {
                if(!(evt.altKey	&& evt.ctrlKey))
                {
                    RCtrl.className='btnSysFlat';
                    LCtrl.className='btnSysFlat';
                    LAlt.className='btnSysFlat';
                    RAlt.className='btnSysFlat';
                    CurrentKeyboardState = kbNormal;
                    UpdateKeypad(kbNormal);
                }
            }
            else if(!document.all && document.getElementById)
            {
                if(!evt.ctrlKey	|| evt.shiftKey)
                {
                    RCtrl.className='btnSysFlat';
                    LCtrl.className='btnSysFlat';
                    RShift.className='btnSysFlat';
                    LShift.className='btnSysFlat';
                    CurrentKeyboardState=kbNormal;
                    UpdateKeypad(kbNormal);
                }
            }
        }
    }
}
function storeCaret	(textEl)
{
    document.getElementById("hexa_txt").value = '';
    if (textEl.createTextRange)
    textEl.caretPos	= document.selection.createRange().duplicate();
}
function isAlpha(ch)
{
    return (ch >= 'a' && ch	<= 'z\uffff') || (ch >=	'A'	&& ch <= 'Z\uffff');
}
function CutToClipboard()
{
    CutTxt = currEdit.selection.createRange();
    CutTxt.execCommand("Cut");
}
function CopyToClipboard()
{
    CopiedTxt =	currEdit.selection.createRange();
    CopiedTxt.execCommand("Copy");
}
function PasteFromClipboard()
{
    currEdit.focus();
    PastedText = currEdit.createTextRange();
    PastedText.execCommand("Paste");
}
function processKeydown(evt)
{
    if (!currEdit) return;
    //evt	= (evt)	? evt :	((event) ? event : null);
    evt	= (evt)	? evt :	(window.event) ? event : null;
    if (evt)
    {
        var	charCode = (evt.charCode) ?	evt.charCode : evt.keyCode;
        //alert(charCode);
        var idx= String.fromCharCode(charCode);
        var	idxChar;
        if(isAlpha(idx))
        {			
			idxChar=String.fromCharCode(charCode).toLowerCase();
        }
        
        if (CurrentKeyboardState ==	kbAlt)
        {
			//alert(charCode);
            //if(ValidChars.indexOf(idxChar)>=0)
            //{
				//alert(charCode);
				if(isAlpha(idx))
					AddText(idxChar);
				else
					AddText(idx);
                ToggleKeyboard(kbNormal);
            //}
        }
        if(charCode	== 17)
        {
            CurrentKeyboardState = kbCtrl;
        }
        else if(CurrentKeyboardState ==	kbCtrl)
        {
            if(charCode==32)
            {
                if(langArray[currEdit.id]==1)
                {
                    setEnglish(currEdit.id);
                }
                else
                {
                    seteng(currEdit.id);
                }
                if(isIE)
                {
                    evt.returnValue=false;
                    evt.cancelBubble=true;
                }
                else if(isGecko)
                {
                    evt.preventDefault();
                    evt.stopPropagation();
                }
            }
        }
    }
}
function AddText(idx)
{
    var	txt;
    if(!currEdit) return;
    //var	whichChar =	String.fromCharCode(idx);
    var	idxChar= idx;
    
    //alert(idx);
   
    
    if(isAlpha(idxChar))
    {
		idxChar= idxChar.toLowerCase();
		var	sId= idxChar.toUpperCase();
    }
    
    switch(CurrentKeyboardState)
    {
        case kbNormal:
			if(CurrentKeyboard.Keys[idxChar] !=	null)
			{
				 //alert(idx);
				txt= String.fromCharCode(CurrentKeyboard.Keys[idxChar].normal);
			}
			break;
        
        case kbShift:
       
			if (isAlpha(idxChar))
			{
				if (CurrentKeyboard.MultiChar[sId])
				{
					txt=CurrentKeyboard.MultiChar[sId];
					ToggleKeyboard(kbShift);
				}
				else if(CurrentKeyboard.Keys[idxChar] != null)
				{			
					//alert(idx);	
					if(CurrentKeyboard.Keys[idxChar].shifted !=	null)
					{
						if(CurrentKeyboard.Keys[idxChar].shifted)
						{
							txt= String.fromCharCode(CurrentKeyboard.Keys[idxChar].shifted);
						}
						ToggleKeyboard(kbShift);
					}
				}
			}
			else if (CurrentKeyboard.Shifted[idx] != null)
			{
				//alert(idx);
				txt= String.fromCharCode(CurrentKeyboard.Shifted[idx]);
				ToggleKeyboard(kbShift);
				
			}
	   

	        
			break;
        case kbAlt:
			if (isAlpha(idxChar))
			{
				//alert(idx);
				if(CurrentKeyboard.Keys[idxChar] !=	null)
				if(CurrentKeyboard.Keys[idxChar].alt !=	null)
				{
					txt= String.fromCharCode(CurrentKeyboard.Keys[idxChar].alt);
					ToggleKeyboard(kbAlt);
				}
			}
			else if (CurrentKeyboard.AltGr[idx] != null)
			{
				txt= String.fromCharCode(CurrentKeyboard.AltGr[idx]);
				//alert(txt);
				ToggleKeyboard(kbAlt);
				
			}
			break;
    }
    
    if(txt==null)
		return;
		
    if (currEdit.createTextRange &&	currEdit.caretPos)
    {
        var	caretPos = currEdit.caretPos;
        caretPos.text =	caretPos.text.charAt(caretPos.text.length -	1) == '	' ?
        txt	+ '	' :	txt;
        currEdit.focus(caretPos);
    }
    else if	(currEdit.selectionStart ||	currEdit.selectionStart	== '0')
    {
        var	vTop=currEdit.scrollTop;
        var	startPos = currEdit.selectionStart;
        var	endPos = currEdit.selectionEnd;
        currEdit.value = currEdit.value.substring(0, startPos)
        + txt
        + currEdit.value.substring(endPos, currEdit.value.length);
        currEdit.focus();
        currEdit.selectionStart	= startPos + 1;
        currEdit.selectionEnd =	startPos + 1;
        currEdit.scrollTop=vTop;
    }
    else
    {
        currEdit.value += txt;
        currEdit.focus(caretPos);
    }
}
function processKeypresses(evt)
{
    console.info('processKeypresses called');
    if (!langArray[currEdit.id]) return;
    evt	= (evt)	? evt :	(window.event) ? event : null;
    if (evt)
    {
        var	charCode = (evt.charCode) ?	evt.charCode :
        ((evt.keyCode) ? evt.keyCode :
        ((evt.which) ? evt.which : 0));
        var	whichASC = charCode	;
        var	whichChar =	String.fromCharCode(whichASC);
        var	idxChar= whichChar.toLowerCase(whichChar);

		if((charCode==46) || (charCode==13))
		{
			return;
		}
		//alert(whichChar);	
        //alert(whichASC);
        if(isIE)
        {
            if(CurrentKeyboardState== kbAlt)
            {
                evt.keyCode=0;
                return;
            }
            
            AddText(idxChar);
            evt.returnValue=false;
            evt.cancelBubble=true;
            return;           
        }
        else if(isGecko)
        {	
			if((CurrentKeyboardState == kbShift) || CurrentKeyboardState == kbCtrl) 
			{
				if(charCode==32)
				{
					evt.preventDefault();
					evt.stopPropagation();
					return;
				}
			}
					
			if(charCode==46)
			{
				return;
			}
			
            if(isValidChar(whichChar))
            {
				AddText(whichChar);
				evt.preventDefault();
				evt.stopPropagation();
            }
        }
        else if(isOpera)
        {
			//alert(charCode);
			if((charCode==13) || (charCode==37) || (charCode==39) ||  (charCode==38)|| (charCode==40)|| (charCode==33) || (charCode==34) || (charCode==46) || (charCode==50)  ) return;
						
			if(evt.keyCode)
			{
				AddText(idxChar);
				//evt.keyCode = codes[whichChar];
				evt.preventDefault();
				evt.stopPropagation();	
			}			
        }
    }
}
function writeButton(idx, perc,	btnClass, str, caption)
{
    document.writeln('<td class="'+btnClass+'" id="'+idx+'"	width='+perc+'%	onclick="javascript:AddText(\''+ str+ '\' );" onmouseover="ShowHelp(\''+ str+ '\');	">'+caption+'</td>');
    Keypads[idx]=document.getElementById(idx);
}
function writeEmptyCell(idx, perc, btnClass, str, caption)
{
    document.writeln('<td class="'+btnClass+'" id="'+idx+'"	width='+perc+'%>&nbsp;</td>');
}
function writeButton2(idx, perc, btnClass, str,	caption)
{
    document.writeln('<td class="'+btnClass+'" id="'+idx+'"	width='+perc+'%	>'+caption+'</td>');
    Keypads[str]=document.getElementById(idx);
}
function writeKeyboard()
{
    document.writeln('<span	dir="ltr">');
    document.writeln('<table border="0"	cellpadding="0"	cellspacing="1"	style="border-collapse:	collapse" bordercolor="#111111"	width="100%" id="AutoNumber1">');
    document.writeln('<tr>');
    document.writeln('<td width="100%" class="btnHelp" id="HelpDesk">');
    document.writeln('<span	lang="ur" dir="rtl">');
    document.writeln('&#1605;&#1575;&#1572;&#1587; &#1705;&#1608; &#1705;&#1587;&#1740;	&#1576;&#1657;&#1606; &#1662;&#1585; &#1604;&#1575;&#1574;&#1740;&#1722;');
    document.writeln('</span>');
    document.writeln('</td>');
    document.writeln('</tr>');
    document.writeln('<tr>');
    document.writeln('<td width="100%">');
    document.writeln('<table border="0"	cellpadding="0"	cellspacing="1"	bordercolor="#111111" width="100%" id="AutoNumber2"	>');
    document.writeln('<tr>');
    writeButton('~', 7,	"btnFlat", '~',	'~');
    writeButton('1', 7,	"btnFlat", '1',	'1');
    writeButton('2', 7,	"btnFlat", '2',	'2');
    writeButton('3', 7,	"btnFlat", '3',	'3');
    writeButton('4', 7,	"btnFlat", '4',	'4');
    writeButton('5', 7,	"btnFlat", '5',	'5');
    writeButton('6', 7,	"btnFlat", '6',	'6');
    writeButton('7', 7,	"btnFlat", '7',	'7');
    writeButton('8', 7,	"btnFlat", '8',	'8');
    writeButton('9', 7,	"btnFlat", '9',	'9');
    writeButton('0', 7,	"btnFlat", "0",	"0");
    writeButton('-', 7,	"btnFlat", '-',	'-');
    writeButton('=', 6,	"btnFlat", '=',	'=');
    document.writeln('</tr>');
    document.writeln('</table>');
    document.writeln('</td>');
    document.writeln('</tr>');
    document.writeln('<tr>');
    document.writeln('<td width="100%">');
    document.writeln('<table border="0"	cellpadding="0"	cellspacing="1"	bordercolor="#111111" width="100%" id="AutoNumber2"	>');
    document.writeln('<tr>');
    writeButton('q', 6,	"btnFlat", 'q',	'q');
    writeButton('w', 7,	"btnFlat", 'w',	'w');
    writeButton('e', 7,	"btnFlat", 'e',	'e');
    writeButton('r', 8,	"btnFlat", 'r',	'r');
    writeButton('t', 8,	"btnFlat", 't',	't');
    writeButton('y', 8,	"btnFlat", 'y',	'y');
    writeButton('u', 8,	"btnFlat", 'u',	'u');
    writeButton('i', 8,	"btnFlat", 'i',	'i');
    writeButton('o', 8,	"btnFlat", 'o',	'o');
    writeButton('p', 8,	"btnFlat", 'p',	'p');
    writeButton('[', 8,	"btnFlat", '[',	'[');
    writeButton(']', 8,	"btnFlat", ']',	']');
    writeButton('\\', 8, "btnFlat",	'\\\\',	'\\\\');
    document.writeln('</tr>');
    document.writeln('</table>');
    document.writeln('</td>');
    document.writeln('</tr>');
    document.writeln('<tr>');
    document.writeln('<td width="100%">');
    document.writeln('<table border="0"	cellpadding="0"	cellspacing="1"	bordercolor="#111111" width="100%" id="AutoNumber3">');
    document.writeln('<tr>');
    writeButton('a', 10, "btnFlat",	'a', 'a');
    writeButton('s', 7,	"btnFlat", 's',	's');
    writeButton('d', 7,	"btnFlat", 'd',	'd');
    writeButton('f', 8,	"btnFlat", 'f',	'f');
    writeButton('g', 8,	"btnFlat", 'g',	'g');
    writeButton('h', 8,	"btnFlat", 'h',	'h');
    writeButton('j', 8,	"btnFlat", 'j',	'j');
    writeButton('k', 8,	"btnFlat", 'k',	'k');
    writeButton('l', 8,	"btnFlat", 'l',	'l');
    writeButton(';', 8,	"btnFlat", ';',	';');
    writeButton(charSingleQuote	, 8, "btnFlat",	'\\\'',	'\\\'');
    document.writeln('</tr>');
    document.writeln('</table>');
    document.writeln('</td>');
    document.writeln('</tr>');
    document.writeln('<tr>');
    document.writeln('<td width="100%">');
    document.writeln('<table border="0"	cellpadding="0"	cellspacing="1"	bordercolor="#111111" width="100%" id="AutoNumber4">');
    document.writeln('<tr>');
    writeButton2('LeftShift', 7, "btnSysFlat", 'LeftShift',	'Shift');
    writeButton('z', 8,	"btnFlat", 'z',	'z');
    writeButton('x', 8,	"btnFlat", 'x',	'x');
    writeButton('c', 8,	"btnFlat", 'c',	'c');
    writeButton('v', 8,	"btnFlat", 'v',	'v');
    writeButton('b', 8,	"btnFlat", 'b',	'b');
    writeButton('n', 9,	"btnFlat", 'n',	'n');
    writeButton('m', 9,	"btnFlat", 'm',	'm');
    writeButton(',', 9,	"btnFlat", ',',	',');
    writeButton('.', 9,	"btnFlat", '.',	'.');
    writeButton('/', 9,	"btnFlat", '/',	'/');
    writeButton2('RightShift', 8, "btnSysFlat",	'RightShift', 'Shift');
    document.writeln('</tr>');
    document.writeln('</table>');
    document.writeln('</td>');
    document.writeln('</tr>');
    document.writeln('<tr>');
    document.writeln('<td width="100%">');
    document.writeln('<table border="0"	cellpadding="0"	cellspacing="1"	bordercolor="#111111" width="100%" id="AutoNumber4">');
    document.writeln('<tr>');
    writeButton('LeftCtrl',	8, "btnSysFlat", 'LeftCtrl', 'Ctrl');
    writeEmptyCell('21', 20);
    writeButton2('AltL', 7,	"btnSysFlat", 'AltL', 'Alt');
    writeButton(' ', 32, "btnFlat",	' ', 'SPACE');
    writeButton2('AltR', 6,	"btnSysFlat", 'AltR', 'AltGr');
    writeEmptyCell('23', 18);
    writeButton('RightCtrl', 9,	"btnSysFlat", 'RightCtrl', 'Ctrl');
    document.writeln('</tr>');
    document.writeln('</table>');
    document.writeln('</td>');
    document.writeln('</tr>');
    document.writeln('</table>');
    document.writeln('</span>');
    RShift=document.getElementById("RightShift");
    LShift=document.getElementById("LeftShift");
    LAlt=document.getElementById("AltL");
    RAlt=document.getElementById("AltR");
    LCtrl=document.getElementById("LeftCtrl");
    RCtrl=document.getElementById("RightCtrl");
    HelpArea=document.getElementById("HelpDesk");
    addEvent(RShift, "click",ToggleShift);
    addEvent(LShift, "click",ToggleShift);
    addEvent(LAlt, "click",ToggleAlt);
    addEvent(RAlt, "click",ToggleAlt);
}


function ShowHelp(idx)
{
    switch(CurrentKeyboardState)
    {
        case kbNormal:
        if (Keypads[idx].id)
        if(CurrentKeyboard.Keys[Keypads[idx].id])
        {
            if (document.all)
            HelpArea.innerText=	'Keyboard:'+idx;
            else if	(!document.all && document.getElementById)
            HelpArea.innerHTML=	'Keyboard:'+idx;
        }
        break;
        case kbShift:
        if (Keypads[idx].id)
        if(CurrentKeyboard.Keys[Keypads[idx].id])
        if(CurrentKeyboard.Keys[Keypads[idx].id].shifted)
        {
            if (document.all)
            HelpArea.innerText=	'Keyboard: Shift+ '+idx;
            else if	(!document.all && document.getElementById)
            HelpArea.innerHTML=	'Keyboard: Shift+ '+idx;
        }
        break;
        case kbAlt:
        if (Keypads[idx].id)
        if(CurrentKeyboard.Keys[Keypads[idx].id])
        if(CurrentKeyboard.Keys[Keypads[idx].id].alt)
        {
            if (document.all)
            HelpArea.innerText=	'Keyboard: Ctrl+Alt+ '+idx;
            else if	(!document.all && document.getElementById)
            HelpArea.innerHTML=	'Keyboard: Ctrl+Shift+ '+idx;
        }
        break;
    }
}

function setUR(sName)
{
    langArray[sName]=1;
    var	el=document.getElementById(sName);


    document.getElementById('kb_table').setAttribute("style" , "display: block");

    //el.focus(1);
    //el.value = '';
    //el.style.backgroundColor="#99FF99";
    //el.setAttribute("style", "FONT-SIZE: 20px; LEFT: 0px; FONT-FAMILY: eng Naskh NorthAmericatype");
    //el.setAttribute("onkeypress" ,"processKeypresses()");
    //el.setAttribute("onfocus" , "setEditor(this)");
    //el.setAttribute("onclick" , "storeCaret(this)");
    //el.setAttribute("dir" , "rtl");

    if (el.createTextRange)
    {
        var	caretPos = el.caretPos;
        el.focus(caretPos);
        currEdit=el;
    }
    else if	(el.selectionStart || el.selectionStart	== '0')
    {
        var	startPos = el.selectionStart;
        el.focus();
        currEdit=el;
        el.selectionStart =	startPos + 1;
        el.selectionEnd	= startPos + 1;
    }
}

function hideKeyBoard(){
    document.getElementById('kb_table').setAttribute("style" , "display: none");
}


function setENG(sName)
{
    langArray[sName]=0;
    var	el=document.getElementById(sName);
    //el.value = '';

    //el.style.backgroundColor="#CCCCFF";

    //el.removeAttribute("style", "FONT-SIZE: 20px; LEFT: 0px; FONT-FAMILY: eng Naskh NorthAmericatype");
    //el.removeAttribute("onkeypress" ,"processKeypresses()");
    //el.removeAttribute("onfocus" , "setEditor(this)");
    //el.removeAttribute("onclick" , "storeCaret(this)");
    //el.removeAttribute("dir" , "rtl");


    if (el.createTextRange && el.caretPos)
    {
        var	caretPos = el.caretPos;
        el.focus(caretPos);
        currEdit=el;
    }
    else if	(el.selectionStart || el.selectionStart	== '0')
    {
        var	startPos = el.selectionStart;
        el.focus();
        currEdit=el;
        el.selectionStart =	startPos + 1;
        el.selectionEnd	= startPos + 1;
    }
}

function seteng(sName)
{
    langArray[sName]=1;
    var	el=document.getElementById(sName);
    el.focus(1);
    el.style.backgroundColor="#99FF99";
    if (el.createTextRange)
    {
        var	caretPos = el.caretPos;
        el.focus(caretPos);
        currEdit=el;
    }
    else if	(el.selectionStart || el.selectionStart	== '0')
    {
        var	startPos = el.selectionStart;
        el.focus();
        currEdit=el;
        el.selectionStart =	startPos + 1;
        el.selectionEnd	= startPos + 1;
    }
}
function setEnglish(sName)
{
    langArray[sName]=0;
    var	el=document.getElementById(sName);
    el.style.backgroundColor="#CCCCFF";
    if (el.createTextRange && el.caretPos)
    {
        var	caretPos = el.caretPos;
        el.focus(caretPos);
        currEdit=el;
    }
    else if	(el.selectionStart || el.selectionStart	== '0')
    {
        var	startPos = el.selectionStart;
        el.focus();
        currEdit=el;
        el.selectionStart =	startPos + 1;
        el.selectionEnd	= startPos + 1;
    }
}
function addEvent(obj, evType, fn)
{
    if (obj.addEventListener)
    {
        obj.addEventListener(evType, fn, true);
        return true;
    }
    else if	(obj.attachEvent)
    {
        var	r =	obj.attachEvent("on"+evType, fn);
        return r;
    }
    else
    {
        alert("Handler could not be	attached");
    }
}
function setEditor(el)
{
    currEdit=el;
    //document.getElementById("hexa_txt").value = '';
}
function makeengEditor(idx, pt)
{
    var	el=document.getElementById(idx);
    el.lang="ur";
    el.dir="rtl";
    el.onFocus=	"setEditor(el)";
    el.onclick="storeCaret(el)";
    el.onkeyup="storeCaret(el)";
    el.wrap="soft";
    with(el.style)
    {
        fontFamily="eng Naskh NorthAmericatype, Tahoma";
        fontSize=pt;
        backgroundColor="#99FF99";
    }
    langArray[idx]=1;
    addEvent(el	, "keypress", processKeypresses);
    addEvent(el	, "keydown", processKeydown);
    addEvent(el	, "keyup", processKeyup);
}
function setKeymap(keymapName)
{
    CurrentKeyboard= KeyMaps[keymapName];
    UpdateKeypad(kbNormal);
}
function biggerFont(idx)
{
    var	el=document.getElementById(idx);
    if (el.style.fontSize == '')
    el.style.fontSize =	'1em';
    el.style.fontSize =	(parseFloat(el.style.fontSize) +1) + "px";
    return el.style.fontSize;
}
function smallerFont(idx)
{
    var	el=document.getElementById(idx);
    if (el.style.fontSize == '')
    el.style.fontSize =	'1em';
    if ((parseFloat(el.style.fontSize) - 0.1) >	0.5)
    el.style.fontSize =	(parseFloat(el.style.fontSize) - 1)	+ "px";
    return el.style.fontSize;
}
function setFontSize(idx, pt)
{
    var	el=document.getElementById(idx);
    el.style.fontSize=pt;
}
function writeengEditor(sName,	rows, cols,	pt)
{
    if(rows>1)
    document.writeln('<TEXTAREA	NAME="'+sName+'" id="'+sName+'"	ROWS="'+rows+'"	COLS="'+cols+'"	style="font-family:eng Naskh NorthAmericatype, Tahoma; font-size:'+pt+';	background-color: #FFFF99 "	lang="ur" dir="rtl"	wrap="soft"	onkeypress="processKeypresses()" onclick="storeCaret(this)"	onkeyup="storeCaret(this)" onFocus=	"setEditor(this)"></TEXTAREA>');
    else
    document.writeln('<input type="text" name="'+sName+'" id="'+sName+'" size="'+cols+'" style="font-family:eng Naskh NorthAmericatype, Tahoma; font-size:'+pt+'; background-color: #FFFF99"	lang="ur" dir="rtl"	onkeypress="processKeypresses()" onclick="storeCaret(this)"	onkeyup="storeCaret(this)" onfocus="setEditor(this)">');
    var	el=document.getElementById(sName);
    langArray[sName]=1;
    el.lang="ur";
    el.dir="rtl";
    el.onFocus=	"setEditor(el)";
    el.onclick="storeCaret(el)";
    el.onkeyup="storeCaret(el)";
    el.wrap="soft";
    with(el.style)
    {
        fontFamily="eng Naskh NorthAmericatype, Tahoma";
        fontSize=pt;
        backgroundColor="#99FF99";
    }
    addEvent(el	, "keypress", processKeypresses);
    addEvent(el	, "keydown", processKeydown);
    addEvent(el	, "keyup", processKeyup);
}
function AddEditor(sName)
{
    langArray[sName]=1;
}
function setFont(idx, fontName)
{
    var	el=document.getElementById(idx);
    with(el.style)
    {
        fontFamily=fontName;
    }
}
function initengEditor(cssPath)
{
    var	ua = navigator.userAgent.toLowerCase();
    isIE = ((ua.indexOf("msie")	!= -1) && (ua.indexOf("opera") == -1) && (ua.indexOf("webtv") == -1));
    isGecko	= (ua.indexOf("gecko") != -1);
    isSafari = (ua.indexOf("safari") !=	-1);
    isKonqueror	= (ua.indexOf("konqueror") != -1);
    //isOpera	= /Opera/.test(ua);
    //isOpera	= (ua.indexOf("Opera") != -1);
    isOpera	= window.opera;
    document.onmouseover = raiseButton;
    document.onmouseout	= normalButton;
    document.onmousedown = lowerButton;
    document.onmouseup = raiseButton;
    addEvent(document, "keydown", Downkeys);
    addEvent(document, "keyup",	Upkeys);
    KeyMaps["engPhonetic"]=engPhonetic;
    setKeymap("engPhonetic");
    var	sPath='';
    if(arguments.length>0) sPath=cssPath;
    //document.writeln('<style type="text/css">@import"' + sPath + 'OpenPad.css";</style>');
}
