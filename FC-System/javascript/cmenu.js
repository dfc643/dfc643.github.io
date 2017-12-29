//获取颜色梯度方法
var ColorGrads = (function(){
	//获取颜色梯度数据
	function GetStep(start, end, step) {
		var colors = [], start = GetColor(start), end = GetColor(end),
			stepR = (end[0] - start[0]) / step,
			stepG = (end[1] - start[1]) / step,
			stepB = (end[2] - start[2]) / step;
		//生成颜色集合
		for(var i = 0, r = start[0], g = start[1], b = start[2]; i < step; i++){
			colors[i] = [r, g, b]; r += stepR; g += stepG; b += stepB;
		}
		colors[i] = end;
		//修正颜色值
		return $$A.map(colors, function(x){ return $$A.map(x, function(x){
			return Math.min(Math.max(0, Math.floor(x)), 255);
		});});
	}
	//获取颜色数据
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
	//获取颜色数组
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

//渐变对象
var ColorTrans = function(elem, options){
	
	this._elem = $$(elem);
	this._timer = null;//定时器
	this._index = 0;//索引
	this._colors = [];//颜色集合
	this._options = {};//参数对象
	
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
  //设置默认属性
  _setOptions: function(options) {
	this.options = {//默认值
		from:	"",//开始颜色(默认空值方便自动获取)
		to:		"#000",//结束颜色
		step:	20,//渐变级数
		speed:	20,//渐变速度
		style:	"color"//设置属性（Scripting属性）
	};
    $$.extend(this.options, options || {});
  },
  //重设颜色集合
  reset: function(options) {
	//根据参数设置属性
	this._options = options = $$.extend( this._options, options || {} );
	//获取颜色集合
	this._colors = ColorGrads( [ options.from, options.to ], options.step );
	this._index = 0;
  },
  //颜色渐入
  transIn: function() {
	this.stop(); this._index++; this._set();
	if(this._index < this._colors.length - 1){
		this._timer = setTimeout($$F.bind( this.transIn, this ), this.speed);
	}
  },
  //颜色渐出
  transOut: function() {
	this.stop(); this._index--; this._set();
	if(this._index > 0){
		this._timer = setTimeout($$F.bind( this.transOut, this ), this.speed);
	}
  },
  //颜色设置
  _set: function() {
	var color = this._colors[Math.min(Math.max(0, this._index), this._colors.length - 1)];
	this._elem.style[this.style] = "rgb(" + color.join(",") + ")";
  },
  //停止
  stop: function() {
	clearTimeout(this._timer);
  }
};
