//��ȡ��ɫ�ݶȷ���
var ColorGrads = (function(){
	//��ȡ��ɫ�ݶ�����
	function GetStep(start, end, step) {
		var colors = [], start = GetColor(start), end = GetColor(end),
			stepR = (end[0] - start[0]) / step,
			stepG = (end[1] - start[1]) / step,
			stepB = (end[2] - start[2]) / step;
		//������ɫ����
		for(var i = 0, r = start[0], g = start[1], b = start[2]; i < step; i++){
			colors[i] = [r, g, b]; r += stepR; g += stepG; b += stepB;
		}
		colors[i] = end;
		//������ɫֵ
		return $$A.map(colors, function(x){ return $$A.map(x, function(x){
			return Math.min(Math.max(0, Math.floor(x)), 255);
		});});
	}
	//��ȡ��ɫ����
	var frag;
	function GetColor(color) {
		var ret = GetData(color);
		if (ret === undefined) {
			if (!frag) {
				frag = document.createElement("textarea");
				frag.style.display = "none";
				document.body.insertBefore(frag, document.body.childNodes[0]);
			};
			try { frag.style.color = color; } catch(e) { return [0, 0, 0]; }
			
			if (document.defaultView) {
				ret = GetData(document.defaultView.getComputedStyle(frag, null).color);
			} else {
				color = frag.createTextRange().queryCommandValue("ForeColor");
				ret = [ color & 0x0000ff, (color & 0x00ff00) >>> 8, (color & 0xff0000) >>> 16 ];
			}
		}
		return ret;
	}
	//��ȡ��ɫ����
	function GetData(color) {
		var re = RegExp;
		if (/^#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i.test(color)) {
			//#rrggbb
			return $$A.map([ re.$1, re.$2, re.$3 ], function(x){
					return parseInt(x, 16);
				});
		} else if (/^#([0-9a-f])([0-9a-f])([0-9a-f])$/i.test(color)) {
			//#rgb
			return $$A.map([ re.$1, re.$2, re.$3 ], function(x){
					return parseInt(x + x, 16);
				});
		} else if (/^rgb\((.*),(.*),(.*)\)$/i.test(color)) {
			//rgb(n,n,n) or rgb(n%,n%,n%)
			return $$A.map([ re.$1, re.$2, re.$3 ], function(x){
					return x.indexOf("%") > 0 ? parseFloat(x, 10) * 2.55 : x | 0;
				});
		}
	}
	
	return function(colors, step){
		var ret = [], len = colors.length;
		if ( step === undefined ) { step = 20; }
		if ( len == 1 ) {
			ret = GetStep( colors[0], colors[0], step );
		} else if ( len > 1 ) {
			for(var i = 0, n = len - 1; i < n; i++){
				var steps = GetStep( colors[i], colors[i+1], step );
				i < n - 1 && steps.pop();
				ret = ret.concat(steps);
			}
		}
		return ret;
	}
})();

//�������
var ColorTrans = function(elem, options){
	
	this._elem = $$(elem);
	this._timer = null;//��ʱ��
	this._index = 0;//����
	this._colors = [];//��ɫ����
	this._options = {};//��������
	
	this._setOptions(options);
	
	this.speed = Math.abs(this.options.speed);
	this.style = this.options.style;
	
	this.reset({
		from: this.options.from || $$D.getStyle(this._elem, this.style),
		to: this.options.to,
		step: Math.abs(this.options.step)
	});
	
	this._set();
};
ColorTrans.prototype = {
  //����Ĭ������
  _setOptions: function(options) {
	this.options = {//Ĭ��ֵ
		from:	"",//��ʼ��ɫ(Ĭ�Ͽ�ֵ�����Զ���ȡ)
		to:		"#000",//������ɫ
		step:	20,//���伶��
		speed:	20,//�����ٶ�
		style:	"color"//�������ԣ�Scripting���ԣ�
	};
    $$.extend(this.options, options || {});
  },
  //������ɫ����
  reset: function(options) {
	//���ݲ�����������
	this._options = options = $$.extend( this._options, options || {} );
	//��ȡ��ɫ����
	this._colors = ColorGrads( [ options.from, options.to ], options.step );
	this._index = 0;
  },
  //��ɫ����
  transIn: function() {
	this.stop(); this._index++; this._set();
	if(this._index < this._colors.length - 1){
		this._timer = setTimeout($$F.bind( this.transIn, this ), this.speed);
	}
  },
  //��ɫ����
  transOut: function() {
	this.stop(); this._index--; this._set();
	if(this._index > 0){
		this._timer = setTimeout($$F.bind( this.transOut, this ), this.speed);
	}
  },
  //��ɫ����
  _set: function() {
	var color = this._colors[Math.min(Math.max(0, this._index), this._colors.length - 1)];
	this._elem.style[this.style] = "rgb(" + color.join(",") + ")";
  },
  //ֹͣ
  stop: function() {
	clearTimeout(this._timer);
  }
};
