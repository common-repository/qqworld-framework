/**
 * jQuery.QQWorldTouch - Using touch event with jQuery
 * Copyright (c) 2010-2013 QQWorld | http://qqworld.org
 * Date: 2013.10.26
 * @author Michael Q Wang
 * @version 1.3.5
 *
 * http://project.qqworld.org/
 */

eval(function(p,a,c,k,e,r){e=function(c){return(c<62?'':e(parseInt(c/62)))+((c=c%62)>35?String.fromCharCode(c+29):c.toString(36))};if('0'.replace(0,e)==0){while(c--)r[e(c)]=k[c];k=[function(e){return r[e]||e}];e=function(){return'([13-9a-df-su-wzA-CE-GI-KM-QSTW-Z]|1\\w)'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(8($){$.fn.QQWorldTouch=8(1l){b 1m={O:\'drag\',5:\'\',1b:\'\',9:\'relative\',c:100,W:\'horizontal\',E:m,X:8(){},Y:8(){},1n:8(t){},1o:8(t){},1p:8(t){}};b 4=$.extend(1m,1l);b 1=a;b F=$(a).F;a.l;a.5;b 14,G={};b Z=("createTouch"in 15);b i={s:Z?"touchstart":"mousedown",n:Z?"touchmove":"mousemove",P:Z?"touchend":"mouseup"};b Q;b 9;b is_goal=m;a.3={I:0,J:0,K:0,M:0,u:0,v:0,o:0,p:0};a.q={s:m,n:m,k:m};a.1c={k:{1q:1r,1s:1r}};a.7={};a.7.k=8(d){b 10={x:Q.f+1.3.u,y:Q.g+1.3.v};b 11=d.5.Q();b 1d={x:11.f-$(1.l).1e()/2,y:11.g-$(1.l).1f()/2};b 1g={x:11.f+d.5.1e()-$(1.l).1e()/2,y:11.g+d.5.1f()-$(1.l).1f()/2};6(10.x>1d.x&&10.y>1d.y&&10.x<1g.x&&10.y<1g.y){6(d.5.12(\'k\')==\'m\'||typeof d.5.12(\'k\')==\'undefined\'){d.5.12(\'k\',\'S\');1.q.k=S;1.1c.k.1q=d.5.F;6(d.1t)d.1t()}}w{6(d.5.12(\'k\')==\'S\'){d.5.12(\'k\',\'m\');1.q.k=m;1.1c.k.1s=d.5.F;6(d.1u)d.1u()}}};a.change={O:8(16){4.O=16},W:8(16){4.W=16},E:8(bl){4.E=bl}};a.7.17=8(N){6(N)N.17();w window.i.returnValue=m};a.7.1w=8(){18{f:$(1.l).j(\'f\')==\'T\'?0:$(1.l).j(\'f\'),g:$(1.l).j(\'g\')==\'T\'?0:$(1.l).j(\'g\')}};a.7.13=8(N){6(Z){b 1h=N.originalEvent.touches[0];18{x:1h.1x,y:1h.1y}}w{18{x:N.1x,y:N.1y}}};a.7.i={s:8(e){14=$(a).14(F);1.l=F+\':eq(\'+14+\')\';Q=$(a).Q();1.5=4.5==\'\'?1.l:4.5;1.7.17(e);1.3.I=1.7.13(e).x;1.3.J=1.7.13(e).y;9=1.7.1w(e);6(4.O==\'1i\'){G.x=$(4.1b).1z()-$(1.5).1z();G.y=$(4.1b).1A()-$(1.5).1A()};1.q.s=S;1.3.u=1.3.v=0;$(15).on(i.n,1.7.i.n).on(i.P,1.7.i.P);4.1n(1)},n:8(e){6(1.q.s||1.q.n){1.q.n=S;1.7.17(e);1.3.K=1.7.13(e).x;1.3.M=1.7.13(e).y;1.3.u=1.3.K-1.3.I;1.3.v=1.3.M-1.3.J;1.3.o=1B(9.f)+1.3.u;1.3.p=1B(9.g)+1.3.v;19(4.O){r\'1C\':19(4.W){r\'1D\':$(1.5).j({9:4.9,g:1.3.p+"z",c:4.c});h;1a:$(1.5).j({9:4.9,f:1.3.o+"z",c:4.c});h}h;r\'1E\':$(1.5).j({9:4.9,f:1.3.o+"z",g:1.3.p+"z",c:4.c});h;r\'1i\':6(1.3.o<0)1.3.o=0;w 6(1.3.o>G.x)1.3.o=G.x;6(1.3.p<0)1.3.p=0;w 6(1.3.p>G.y)1.3.p=G.y;$(1.5).j({9:4.9,f:1.3.o+"z",g:1.3.p+"z",c:4.c});h;r\'1F\':h;1a:$(1.5).j({9:4.9,f:1.3.o+"z",g:1.3.p+"z",c:4.c});h};4.1o(1)}},P:8(e){6(1.q.s==S){$(15).1G(i.n,1.7.i.n).1G(i.P,1.7.i.P);19(4.O){r\'1C\':$(1.5).j({c:\'T\'});19(4.W){r\'1D\':6(1.3.M>1.3.J&&A.B(1.3.v)>C)4.E?4.X():4.Y();w 6(1.3.M<1.3.J&&A.B(1.3.v)>C)4.E?4.Y():4.X();w $(1.5).1k({g:9.g});h;1a:6(1.3.K>1.3.I&&A.B(1.3.u)>C)4.E?4.X():4.Y();w 6(1.3.K<1.3.I&&A.B(1.3.u)>C)4.E?4.Y():4.X();w $(1.5).1k({f:9.f},\'1H\');h}h;r\'1E\':b H=V=\'\';$(1.5).1k({g:0,f:0},\'1H\');6(1.3.K>1.3.I&&A.B(1.3.u)>C)H=\'R\';6(1.3.K<1.3.I&&A.B(1.3.u)>C)H=\'L\';6(1.3.M>1.3.J&&A.B(1.3.v)>C)V=\'D\';6(1.3.M<1.3.J&&A.B(1.3.v)>C)V=\'U\';6(H+V!=\'\')eval(\'4.\'+H+V+\'()\');$(1.5).j({c:\'T\'});h;r\'1i\':$(1.5).j({c:\'T\'});h;r\'1F\':h;1a:$(1.5).j({c:\'T\'});h};4.1p(1);1.q.s=1.q.n=m}}};$(15).on(i.s,F,1.7.i.s);18 a}})(jQuery);',[],106,'|_this||point|opts|target|if|action|function|position|this|var|zIndex|args||left|top|break|event|css|goal|current|false|move|offsetX|offsetY|status|case|start||absOffsetX|absOffsetY|else|||px|Math|abs|50||inversion|selector|range||startX|startY|nowX||nowY|ev|mode|end|offset||true|auto|||direction|next|prev|supportsTouches|dragOffset|potision|data|getMousePoint|index|document|str|preventDefault|return|switch|default|container|nonce|coord_1|outerWidth|outerHeight|coord_2|evt|constrain||animate|options|defaults|onstart|onmove|onend|now|null|before|enter|leave||getPosition|pageX|pageY|width|height|parseInt|nav|vertical|direct|other|off|fast'.split('|'),0,{}))