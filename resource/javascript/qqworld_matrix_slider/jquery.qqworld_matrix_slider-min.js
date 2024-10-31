/**
 * jQuery.QQWorldMatrixSlider - Easy Matrix slider For jQuery
 * Copyright (c) 2010-2013 QQWorld | http://qqworld.org
 * Date: 2013.10.2
 * @author Michael Q Wang
 * @version 1.0.3
 *
 * http://project.qqworld.org
 */
eval(function(p,a,c,k,e,r){e=function(c){return(c<62?'':e(parseInt(c/62)))+((c=c%62)>35?String.fromCharCode(c+29):c.toString(36))};if('0'.replace(0,e)==0){while(c--)r[e(c)]=k[c];k=[function(e){return r[e]||e}];e=function(){return'([35-9a-hj-mo-zA-GI-VX-Z]|1\\w)'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(6($){$.fn.o=6(Y){e Z={J:"horizontal",q:4,r:1,K:"",L:1000,10:3000,11:true,s:1,x:12,t:1,y:12,M:0,l:\'z\'};e 5=$.extend(Z,Y);e 3=7;e b=0;e W,H,f;e N;e l,O=new Array("swing","easeInQuad","easeOutQuad","easeInOutQuad","easeInCubic","easeOutCubic","easeInOutCubic","easeInQuart","easeOutQuart","easeInOutQuart","easeInQuint","easeOutQuint","easeInOutQuint","easeInSine","easeOutSine","easeInOutSine","easeInExpo","easeOutExpo","easeInOutExpo","easeInCirc","easeOutCirc","easeInOutCirc","easeInElastic","easeOutElastic","easeInOutElastic","easeInBack","easeOutBack","easeInOutBack","easeInBounce","easeOutBounce","easeInOutBounce");e u={};u.13=6(A,14){P(arguments.B){C 1:{D Q(15.z()*A+1);m}C 2:{D Q(15.z()*(14-A+1)+A);m}R:{D 0;m}}};u.16=6(){l=5.l==\'z\'?O[u.13(0,O.B-1)]:5.l};7.9={};7.9.E=6(){$(3).clearQueue();u.16();P(5.J){C\'17\':{$(3).18({top:"-"+5.r*$(3).a("g").19()*b+"px"},5.L,l);m}R:{$(3).18({left:"-"+5.q*W*b+"px"},5.L,l);m}}3.9.1b()};7.9.v=6(){b++;b=b==f?0:b;3.9.E()};7.9.F=6(){b--;b=b<0?f-1:b;3.9.E()};7.9.1c=6(n){b=n;3.9.E()};7.9.S=6(){N=setInterval(3.9.v,5.10)};7.9.1d=6(){clearInterval(N)};7.9.1b=6(){$(3).8().8().a(\'.j-h\').a(\'g\').removeClass("b").eq(b).addClass("b")};7.d={};7.d.h=6(){e 1e=5.K?\' id="\'+5.K+\'"\':"";$(3).1f(\'<k\'+1e+\' p="1g-1h-1i-h"/>\');$(3).1f(\'<k p="1g-1h-1i"/>\')};7.d.1j=6(){c(5.s){$(3).8().T(\'<k p="o-w F"></k>\');$(3).8().T(\'<k p="o-w v"></k>\');c(5.x){$(3).8().8().a(\'.o-w\').G("1k")}}};7.d.j=6(){c(5.t){e U="";for(e i=0;i<f;i++){e 1l=i==0?\' p="b"\':\'\';U+=\'<g\'+1l+\'>\'+(i+1)+\'</g>\'}$(3).8().T(\'<k p="j-h"><ul>\'+U+\'</ul></k>\');c(5.y){$(3).8().a(\'.j-h\').G("1k")}}};7.d.1n=6(){window.onresize=6(){};c(5.t){$(3).8().8().a(\'.j-h\').a(\'g\').V("mouseover",6(){3.9.1c($(7).index())})}c(5.s){$(3).8().8().a(\'.F\').V("1o",6(){3.9.F()});$(3).8().8().a(\'.v\').V("1o",6(){3.9.v()})}$(3).8().hover(6(){c(5.11){3.9.1d()}c(5.s&&5.x){$(7).8().a(\'.o-w\').1p(\'I\')}c(5.t&&5.y){$(7).8().a(\'.j-h\').1p(\'I\')}},6(){c(5.M){3.9.S()}c(5.s&&5.x){$(7).8().a(\'.o-w\').G(\'I\')}c(5.t&&5.y){$(7).8().a(\'.j-h\').G(\'I\')}})};7.d.1q=6(){W=$(3).a("g").outerWidth();H=$(3).a("g").19();$(3).X({position:"relative",overflow:"hidden"}).8().X({1r:5.q*W,height:5.r*H});P(5.J){C\'17\':{m}R:{$(3).X({1r:f*100+"%",});m}}};7.d.1s=6(){f=Q($(3).a("g").B/(5.q*5.r));f=$(3).a("g").B%(5.q*5.r)==0?f:f+1;c(f>1){3.d.h();3.d.1j();3.d.j();3.d.1q();3.d.1n();c(5.M)3.9.S()}};7.d.1s();D 7}})(jQuery);',[],91,'|||_this||opts|function|this|parent|action|find|currentPage|if|create|var|totalPages|li|container||pager|div|easing|break||QQWorldMatrixSlider|class|cols|rows|showNav|showPager|lib|gotoNext|button|autoHideNav|autoHidePager|random|under|length|case|return|play|gotoPrev|fadeOut||normal|direction|container_id|speed|auto|loop|easingTypes|switch|parseInt|default|autoPlay|before|html|bind||css|options|defaults|pause|hoverStopPlay|false|randomBy|over|Math|getEasingType|vertical|animate|outerHeight||changePagesStyle|gotoPlay|stopPlay|id_str|wrap|qqworld|matrix|slider|nav|fast|class_str||events|click|fadeIn|styles|width|init'.split('|'),0,{}))