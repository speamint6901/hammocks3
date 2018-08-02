var particleSystem = null;
var stage = null;

//  ウィンドウのロードが終わり次第、初期化コードを呼び出す
window.addEventListener("load", function () {
 console.log('[particlejs]');
 // Stageオブジェクトを作成します。表示リストのルート
 stage = new createjs.Stage("bonfire");
 // パーティクルシステム作成
 particleSystem = new particlejs.ParticleSystem();
 // パーティクルシステムの描画コンテナーを表示リストに登録
 stage.addChild(particleSystem.container);
 // Particle Develop( http://ics-web.jp/projects/particle-develop/ ) から書きだしたパーティクルの設定を読み込む

 particleSystem.importFromJson(
  // パラメーターJSONのコピー＆ペースト ここから--
  {
   "bgColor": "#00000",
   "width": 960,
   "height": 640,
   "emitFrequency": "260",
   "startX": 480,
   "startXVariance": "80",
   "startY": 560,
   "startYVariance": "10",
   "initialDirection": "50",
   "initialDirectionVariance": 360,
   "initialSpeed": "3",
   "initialSpeedVariance": "1",
   "friction": "0.055",
   "accelerationSpeed": "0.1445",
   "accelerationDirection": "275",
   "startScale": "0.95",
   "startScaleVariance": "0.85",
   "finishScale": "0.1",
   "finishScaleVariance": "0.5",
   "lifeSpan": "110",
   "lifeSpanVariance": "30",
   "startAlpha": "0.6",
   "startAlphaVariance": "0.5",
   "finishAlpha": "0.1",
   "finishAlphaVariance": "0.6",
   "shapeIdList": [
    "blur_circle"
   ],
   "startColor": {
    "hue": "23",
    "hueVariance": "10",
    "saturation": "90",
    "saturationVariance": 0,
    "luminance": "53",
    "luminanceVariance": "10"
   },
   "blendMode": true,
   "alphaCurveType": "1"
  }
  // パラメーターJSONのコピー＆ペースト ここまで---
 );

 // フレームレートの設定
 createjs.Ticker.framerate = 60;
 // requestAnimationFrameに従った呼び出し
 createjs.Ticker.timingMode = createjs.Ticker.RAF;
 // 定期的に呼ばれる関数を登録
 createjs.Ticker.addEventListener("tick", handleTick);
});


function handleTick() {
 // パーティクルの発生・更新
 particleSystem.update();
 // 描画を更新する
 stage.update();
}
