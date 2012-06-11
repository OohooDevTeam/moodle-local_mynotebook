/* esta funciion calcula el numero de lienas del textarea en cualquier tamaño esta es una funccionde  jquery llamada countlines*/
 var top_init=105;/*posicion inicial de la pantalla (textaarea)*/
 var browser_info= new Array();
    jQuery.each(jQuery.browser, function(i, val) {
			browser_info[i]=val;

    });
/*
esta funcion  de jquery hace referencia a este url  http://onehackoranother.com/projects/jquery/jquery-grab-bag/autogrow-textarea.html

*/
(function($) {

    /*
     * Auto-growing textareas; technique ripped from Facebook
     */
    $.fn.autogrow = function(options) {
        
        this.filter('textarea').each(function() {
            
            var $this       = $(this),
                minHeight   = $this.height(),
                lineHeight  = $this.css('lineHeight');
            
            var shadow = $('<div></div>').css({
                position:   'absolute',
                top:        -10000,
                left:       -10000,
                width:      $(this).width() - parseInt($this.css('paddingLeft')) - parseInt($this.css('paddingRight')),
                fontSize:   $this.css('fontSize'),
                fontFamily: $this.css('fontFamily'),
                lineHeight: $this.css('lineHeight'),
                resize:     'none'
            }).appendTo(document.body);
            for(var i in browser_info )
				{
					if(i==='msie' )
						{
							var top_init=24;
							break	;
						}
						else{
								var top_init=20;							
								break;	
							}
						
				}
            var update = function() {
    
                var times = function(string, number) {
                    for (var i = 0, r = ''; i < number; i ++) r += string;
                    return r;
                };
                
                var val = this.value.replace(/</g, '&lt;')
                                    .replace(/>/g, '&gt;')
                                    .replace(/&/g, '&amp;')
                                    .replace(/\n$/, '<br/>&nbsp;')
                                    .replace(/\n/g, '<br/>')
                                    .replace(/ {2,}/g, function(space) { return times('&nbsp;', space.length -1) + ' ' });
                
                shadow.html(val);
				var top_o=parseFloat($(this).css('height'));
				/* aqui verifica si el textarea  excede de tamaño a 260px de alto  en caso que se pase del tope que da estatica 
					 y  viceversa
				 */
				if (top_o<260 || shadow.height()<=240)					
					{
				       	$(this).css('height', Math.max(shadow.height() + top_init, minHeight));
						$(this).css('overflow-y','hidden' );							
					}
				if (top_o==260 || top_o==272)					
						{
							$(this).css('overflow-y','auto' );							
						}
			 		if (top_o<parseFloat($(this).css('height')))
						{
							var top=parseFloat($(this).css('top'));

							$(this).css('top', big = (top===105) ? top-22 : top-30 );
							 var aSoundObject2 = soundManager.createSound({id:'mySound1',url:'sound/typewriter_line_break.mp3'});aSoundObject2.play();		  		  
							 /*  ahce el efecto de sonido  encaso que pase de un  salto de linea*/
						}
			 		if (top_o>parseFloat($(this).css('height')))
						{
							var top=parseFloat($(this).css('top'));
							$(this).css('top',big = (top===83) ? top+22 : top+30);
						}

				

            }

            $(this).change(update).keyup(update).keydown(update);
            update.apply(this);
            
        });
        
        return this;
        
    }
    
})(jQuery);
/* function verifica si la teccla que esta tipeando es mayusculas */
function isCapslock(e){

	var ascii_code	= e.which;
		var shift_key	= e.shiftKey;
		if( (65 <= ascii_code) && (ascii_code <= 90) && !shift_key )
		{
			return true
		}
		else
		{
			return false;
		}
}



  
  var $keyboard = jQuery.noConflict();	/*carga la variable en jquery para evitar conflictos*/
  var caps_lock=false;
  var atCount = 2;/* posicion incial del contador de lineas debe esta en 2 para ciomaprar*/
  var control_sc=false;/* estado de control del scroll cuando hay un salto de liena*/
  var click_focus=false;
  
  /* hace que el textarea meustre el curson cunado incial la pagina*/
	$keyboard(document).ready(function(){
	$keyboard("#write").focus();
	
  });
  
  $keyboard(function() {
    $keyboard('#write').autogrow();
  });

  /* eventos del mouse */
  $keyboard(function(){
	  var $write = $keyboard('#write'),
		  shift = false,
		  capslock = false;
	  /* evento mousedown= click hacia abajo mouseup= click suelto o hacia arriba  este vento aplica solamente cuando esta en el teclado virtual  */
	  $keyboard('#keyboard li').bind({
		   mousedown: function() {
				  /*cuando esta en mouse down  cambia la posicion de la tecla en 1px alto y 1 derecha para ahcer e efecto */
			  $keyboard(this).css('position','relative');
			  $keyboard(this).css('top','2px');
			  $keyboard(this).css('left','2px');
			  $keyboard(this).css('border-color','#e5e5e5');	

			  var $this = $keyboard(this),
			  
				  character = jQuery.trim($this.html()); // If it's a lowercase letter, nothing happens to this variable
		  if (! $this.hasClass('send'))
		  {

     			 if ($this.hasClass('return'))
				 {
		  			 /*  hace el efecto de sonido  encaso que clique return o salto de linea */					 
	  			 	 var aSoundObject1 = soundManager.createSound({id:'mySound3',url:'sound/typewriter_line_break.mp3'});
					 aSoundObject1.play();		  		  
				 }
			 else{
		  			 /*  hace el efecto de sonido  encaso que clicquie cualquier tecla */
					 var aSoundObject = soundManager.createSound({id:'mySound2',url:'sound/typewriter_key_4.mp3'});
					 	aSoundObject.play();		  		  
		  
				 }
				

			  // Shift keys
			  /* cuando presion click en la tecla shift cambia el estado de las teclas */
			  if ($this.hasClass('left-shift') || $this.hasClass('right-shift')) {
				  $keyboard('.letter').toggleClass('uppercase');
				  $keyboard('.symbol span').toggle();
			  
				  shift = (shift === true) ? false : true;
				  capslock = false;
				  return false;
			  }
		  
		  // Caps lock
			  /* aqui sucede cuando presiiono la tecla bloq mayus*/
			  if ($this.hasClass('capslock')) {
				  $keyboard('.letter').toggleClass('uppercase');
				  capslock = true;
				  return false;
			  }
		  
		  // Delete
  				/*seccion que borra una character*/
				  if ($this.hasClass('delete')) {	
  
					  document.getElementById('write').value=document.getElementById('write').value.substr(0, document.getElementById('write').value.length - 1);
				  return false;
			  }
		  
		  // Special characters
		  
			  if ($this.hasClass('symbol')) character = $keyboard('span:visible', $this).html();
			  if ($this.hasClass('space')) character = ' ';
			  if ($this.hasClass('tab')) character = "\t";
			  if ($this.hasClass('return')) character = "\n";


		  // Uppercase letter
			  if ($this.hasClass('uppercase')) character = character.toUpperCase();
		  
		  // Remove shift once a key is clicked.
			  if (shift === true) {
				  $keyboard('.symbol span').toggle();
				  if (capslock === false) $keyboard('.letter').toggleClass('uppercase');
			  
				  shift = false;
			  }
		  				if(click_focus==true)
						{
						  $keyboard('#write').val('');
						  click_focus=false;
						}
		  // Add the character
						  if (! $this.hasClass('delete')) {	
							  document.getElementById('write').value+=character;
						  }
			    $keyboard('#write').autogrow();						  
				/* aqui hace el efecto de la pantalla cuando hay mas de una linea en en textaraea  va subiendo hasta que obtenga 14 lineas para estar al nivel de monitor */						  
			 
			  }

			},
			   mouseup:  function (){
			/*				en el evento mouse up lo que hace es dejar en su poisicion original de la tecla conla cuakl termina ahcer el efecto de las teclas*/
			  $keyboard(this).css('position','static');
			  $keyboard(this).css('top','2px');
			  $keyboard(this).css('left','2px'); 
			  $keyboard(this).css('border-color','#000');	
			  	if(! $keyboard(this).hasClass('send'))
				{
				  $keyboard("#write").focus();
				}
			}
			
	  });
	  /* este sucde unicamente cuando hago click al boton send simplemente lo que hace es hacer el efecto de borrado de chartaters y envia el correo*/
	  $keyboard('#send').stop(true,true).click(function()
	  {
	  			 /*  hace el efecto de sonido  encaso que clique send unicamente  */					 
				 var aSoundObject5 = soundManager.createSound({id:'mySound5',url:'sound/typewriter-paper-1.mp3'});aSoundObject5.play();		  		  													 
				 /*aqui hace la animacion del papel cuando se animo teniendo como sincronia el sonido se corre 300 px hacia arriba  
				 y cambiar la posicion oculta de tal modo sale detras de la mquinba de escribir  con una anmacion mas reducidad  */
				 
 				$keyboard('#write').animate({"top": "-=300px"},'fast',function() {
				var message=$keyboard(this).val();
				$keyboard(this).css('height','58px');
				$keyboard(this).val('     mail sent    ');
				$keyboard(this).css('top','163px');
				$keyboard(this).css('overflow-y','hidden' );				
				$keyboard(this).css('z-index','1');
					$keyboard(this).animate({"top": "-=58px"},'slow',function(){
									$keyboard(this).css('z-index','3');
									$keyboard.post("Mail/sendmail.php", { mail:message  },
										function(data){
									
										});
					});		
					click_focus=true;				

				 });
				

  	  });
	  
	  /*aqui sucede los eventos del teclado cuando escibo en eltextarea hay tres eventos que son aplicados
  
		  1.keydown--> tecla hacia abajo ,
		  2.keypres--> tecla presionada
		  3.keyup----> tecla hacia arriba
	  */
	  var keypressed = 0;

	  $keyboard('#write').bind(
	  {
		  /*en keydown ace el mismo efecto  que mouse down y veriffica exclusivamente lo charaters para hacer el mismo efecto del mouse*/
		  click:function(event){
					if(click_focus==true)
						{
						  $keyboard('#write').val('');
						  click_focus=false;
						}
			  },
		  
		  keydown:	function(event) {
			

  			  /* esta variable captura la tecla presionada cuando esta ekeydown lo que haces es mover 2 px hacia abajo y 2 a la derecha patra que efecto se mas inetersante*/
			  var lowercase=String.fromCharCode(event.keyCode);


			  switch(event.keyCode)
				{
					case 8:
						lowercase='delete';
					break;
					case 13:
						lowercase='return';
						break;
					case 16:
						lowercase='shift';
					break;						
					case 20:
					 	lowercase="caps lock";

 							if (isCapslock(event)===true ||caps_lock===false)
							{
								if (caps_lock===false)
								{
								$keyboard('.letter').toggleClass('uppercase');	
								caps_lock=true;
								}
							}
							else
							{
								if (event.keyCode!=32)
								{
									if (caps_lock===true)
									{
										$keyboard('.letter').toggleClass('uppercase');										
										caps_lock=false;
									}
								}
							}

					break;
					case 32:
						lowercase="&nbsp;";	
			  		break;					
					case 186:
						lowercase='<span class="off">;</span><span class="on">:</span>';	
			  		break;
					
					case 188:
						lowercase='<span class="off">,</span><span class="on">&lt;</span>';	
			  		break;
					case 190:
						lowercase='<span class="off">.</span><span class="on">&gt;</span>';	
			  		break;
					case 191:
						lowercase='<span class="off">/</span><span class="on">?</span>';	
			  		break;
					case 222:
						lowercase='<span class="off">'+"'"+'</span><span class="on">&quot;</span>';	
			  		break;				
					
					
				}


			  $keyboard('#keyboard li').each(function(){
				  /*aqui hace elmismo efecto mousedown*/

				  if ((jQuery.trim($keyboard(this).html())===lowercase.toLowerCase())|| jQuery.trim($keyboard(this).html())===lowercase)
				  {
					  $keyboard(this).css('position','relative');
					  $keyboard(this).css('top','2px');
					  $keyboard(this).css('left','2px');
					  $keyboard(this).css('border-color','#e5e5e5');	
				  }
		  

				  			
		  });
		  			 if (event.keyCode===13)
			 {
	  		 	 var aSoundObject1 = soundManager.createSound({id:'mySound3',url:'sound/typewriter_line_break.mp3'});
			 /*  hace el efecto de sonido  encaso que pase de un  salto de linea*/
				 	 aSoundObject1.play();		  		  
			 }
			 else{

				 var aSoundObject = soundManager.createSound({id:'mySound2',url:'sound/typewriter_key_4.mp3'});
				 	aSoundObject.play();		  		  
			 /*  hace el efecto de sonido  encaso que tipie cualquier tecla */
		  
			 }


	  },
	  keyup: function(event){
		  /*esto ocuurre el ebvento key up loque hace es que la tecla esta presioanndo en este instante convierte a la position original */
			  var lowercase=String.fromCharCode(event.keyCode);
			  switch(event.keyCode)
				{
					case 8:
						lowercase='delete';
					break;
					case 13:
						lowercase='return';
						break;
					case 16:
						lowercase='shift';
					break;						
					case 20:
					 	lowercase="caps lock";
					break;
					
					case 32:
						lowercase="&nbsp;";	
			  		break;
					case 186:
						lowercase='<span class="off">;</span><span class="on">:</span>';	
			  		break;
					
					case 188:
						lowercase='<span class="off">,</span><span class="on">&lt;</span>';	
			  		break;
					case 190:
						lowercase='<span class="off">.</span><span class="on">&gt;</span>';	
			  		break;
					case 191:
						lowercase='<span class="off">/</span><span class="on">?</span>';	
			  		break;
					case 222:
						lowercase='<span class="off">'+"'"+'</span><span class="on">&quot;</span>';	
			  		break;
					

				}

  	
			  	  /*aqui hace elmismo efecto mouseup*/
			  $keyboard('#keyboard li').each(function(){
  
				  if (jQuery.trim($keyboard(this).html())===lowercase.toLowerCase())
				  {
					  $keyboard(this).css('position','static');
					  $keyboard(this).css('top','2px');
					  $keyboard(this).css('left','2px');
					  $keyboard(this).css('border-color','#000');	
				  }

				  
		  });



	  },
	  keypress: function(event){
		 /* Este es el evento ocurrre keypress (tecla presionada) cuando tipea reconoce si  en el textraea que esta tiepeando es mayusuclas o minusculas*/

		 						if (isCapslock(event)===true)
							{
								if (caps_lock===false)
								{
								$keyboard('.letter').toggleClass('uppercase');	
								caps_lock=true;
								}
							}
							else
							{
								if (event.keyCode!=32)
								{
									if (caps_lock===true)
									{
										$keyboard('.letter').toggleClass('uppercase');										
										caps_lock=false;
									}
								}
							}


	
	  }
	  });
});
  
