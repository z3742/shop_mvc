// ============================================================
// AE 15秒视频自动制作脚本 - AE 2024 安全版
// 使用方法：File > Scripts > Run Script File...
// ============================================================

{
    var compName = "Main_15s";
    var compWidth = 1920;
    var compHeight = 1080;
    var compFPS = 30;
    var compDuration = 15;
    
    var colors = {
        blue: [0.212, 0.545, 0.871],
        purple: [0.549, 0.361, 0.906],
        green: [0.035, 0.619, 0.416],
        orange: [0.937, 0.624, 0.153],
        red: [0.929, 0.263, 0.188],
        white: [1, 1, 1],
        black: [0, 0, 0],
        darkBg: [0.039, 0.039, 0.102],
        greenScreen: [0, 1, 0]
    };

    // 安全获取属性（带空值检查）
    function safeSetValue(obj, val) {
        if (obj && obj.setValue) {
            try { obj.setValue(val); } catch(e) {}
        }
    }
    
    function safeSetValueAtTime(obj, t, val) {
        if (obj && obj.setValueAtTime) {
            try { obj.setValueAtTime(t, val); } catch(e) {}
        }
    }
    
    function safeAddProperty(group, name) {
        try { return group.addProperty(name); } catch(e) { return null; }
    }
    
    function safeSetProp(effect, propName, val) {
        if (!effect) return;
        try { effect.property(propName).setValue(val); } catch(e) {}
    }
    
    function safeSetPropAtTime(effect, propName, t, val) {
        if (!effect) return;
        try { effect.property(propName).setValueAtTime(t, val); } catch(e) {}
    }

    // ============================================================
    // 主函数
    // ============================================================
    function main() {
        app.beginUndoGroup("AE 15s Video Auto Setup");
        
        try {
            if (!app.project) app.newProject();
            
            var comp = createComposition();
            if (!comp) {
                alert("Error: Failed to create composition");
                return;
            }
            
            comp.openInViewer();
            
            createScene1(comp);
            createScene2(comp);
            createScene3(comp);
            createScene4(comp);
            createAdjustmentLayer(comp);
            
            alert("Script completed successfully!");
            
        } catch (e) {
            alert("Error: " + e.toString());
        } finally {
            app.endUndoGroup();
        }
    }

    // ============================================================
    // 创建合成
    // ============================================================
    function createComposition() {
        var comp = app.project.items.addComp(
            compName,
            compWidth,
            compHeight,
            1,
            compDuration,
            compFPS
        );
        comp.workAreaStart = 0;
        comp.workAreaDuration = compDuration;
        return comp;
    }

    // ============================================================
    // Scene 1: 关键帧动画 - 文字入场
    // ============================================================
    function createScene1(comp) {
        var textLayer = comp.layers.addText("INNOVATION");
        textLayer.name = "S1_INNOVATION";
        textLayer.startTime = 0;
        textLayer.outPoint = 4;
        
        // 文字样式
        var textProp = textLayer.property("ADBE Text Properties");
        var textDoc = textProp.property("ADBE Text Document").value;
        textDoc.fontSize = 120;
        textDoc.tracking = 25;
        textDoc.fillColor = colors.white;
        textProp.property("ADBE Text Document").setValue(textDoc);
        
        // 位置（通过 Transform）
        textLayer.property("Transform").property("Position").setValue([960, 540]);
        
        // 3D 图层
        textLayer.threeDLayer = true;
        
        // 关键帧动画
        var position = textLayer.property("Transform").property("Position");
        var opacity = textLayer.property("Transform").property("Opacity");
        var scale = textLayer.property("Transform").property("Scale");
        var rotationX = textLayer.property("Transform").property("X Rotation");
        
        position.setValueAtTime(0, [960, 800, 0]);
        opacity.setValueAtTime(0, 0);
        scale.setValueAtTime(0, [130, 130, 100]);
        rotationX.setValueAtTime(0, 90);
        
        position.setValueAtTime(2.5, [960, 540, 0]);
        opacity.setValueAtTime(2.5, 100);
        scale.setValueAtTime(2.5, [100, 100, 100]);
        rotationX.setValueAtTime(2.5, 0);
        
        position.setValueAtTime(2.67, [960, 520, 0]);
        position.setValueAtTime(3, [960, 540, 0]);
        
        textLayer.motionBlur = true;
    }

    // ============================================================
    // Scene 2: 形状与遮罩
    // ============================================================
    function createScene2(comp) {
        var bgSolid = comp.layers.addSolid(colors.darkBg, "S2_Gradient_BG", compWidth, compHeight, 1);
        bgSolid.startTime = 3;
        
        var s1Layer = comp.layers.byName("S1_INNOVATION");
        if (s1Layer) bgSolid.moveAfter(s1Layer);
        
        // Gradient Ramp
        var gradientEffect = safeAddProperty(bgSolid.Effects, "ADBE Ramp");
        if (!gradientEffect) gradientEffect = safeAddProperty(bgSolid.Effects, "Gradient Ramp");
        if (gradientEffect) {
            safeSetProp(gradientEffect, "ADBE Ramp-0004", [0.102, 0.137, 0.49]);
            safeSetProp(gradientEffect, "ADBE Ramp-0005", [0.29, 0.08, 0.549]);
            safeSetPropAtTime(gradientEffect, "ADBE Ramp-0002", 3, [960, 1080]);
            safeSetPropAtTime(gradientEffect, "ADBE Ramp-0002", 6, [960, 0]);
        }
        
        // 文字遮罩层
        var matteText = comp.layers.addText("INNOVATION");
        matteText.name = "S2_Matte_Text";
        matteText.startTime = 3;
        matteText.outPoint = 6.5;
        
        var matteProp = matteText.property("ADBE Text Properties");
        var matteDoc = matteProp.property("ADBE Text Document").value;
        matteDoc.fontSize = 80;
        matteDoc.tracking = 40;
        matteDoc.fillColor = colors.white;
        matteProp.property("ADBE Text Document").setValue(matteDoc);
        
        var matteScale = matteText.property("Transform").property("Scale");
        matteScale.setValueAtTime(3, [50, 50, 100]);
        matteScale.setValueAtTime(5.25, [150, 150, 100]);
        
        // Adjustment Layer（用纯色模拟）
        var lightAdj = comp.layers.addSolid([0, 0, 0], "S2_Light_Pass", comp.width, comp.height, comp.pixelAspect, comp.duration);
        lightAdj.adjustmentLayer = true;
        lightAdj.name = "S2_Light_Pass";
        lightAdj.startTime = 3;
        lightAdj.outPoint = 6.5;
        
        // CC Light Sweep
        var lightEffect = safeAddProperty(lightAdj.Effects, "ADBE CCLightSweep");
        if (!lightEffect) lightEffect = safeAddProperty(lightAdj.Effects, "CC Light Sweep");
        if (lightEffect) {
            safeSetPropAtTime(lightEffect, "ADBE CCLightSweep-0002", 3, [-200, 540]);
            safeSetPropAtTime(lightEffect, "ADBE CCLightSweep-0002", 6, [2120, 540]);
        }
    }

    // ============================================================
    // Scene 3: 效果与预设
    // ============================================================
    function createScene3(comp) {
        var createText = comp.layers.addText("CREATE");
        createText.name = "S3_CREATE";
        createText.startTime = 6;
        
        var createProp = createText.property("ADBE Text Properties");
        var createDoc = createProp.property("ADBE Text Document").value;
        createDoc.fontSize = 150;
        createDoc.tracking = 50;
        createDoc.fillColor = colors.white;
        createProp.property("ADBE Text Document").setValue(createDoc);
        
        // Gaussian Blur
        var blurEffect = safeAddProperty(createText.Effects, "ADBE Gaussian Blur 2.0");
        if (!blurEffect) blurEffect = safeAddProperty(createText.Effects, "ADBE Gaussian Blur");
        if (blurEffect) {
            safeSetPropAtTime(blurEffect, "ADBE Gaussian Blur 2.0-0002", 6, 60);
            safeSetPropAtTime(blurEffect, "ADBE Gaussian Blur 2.0-0002", 8, 0);
        }
        
        // Glow
        var glowEffect = safeAddProperty(createText.Effects, "ADBE Glo2");
        if (!glowEffect) glowEffect = safeAddProperty(createText.Effects, "ADBE Glow");
        if (glowEffect) {
            safeSetProp(glowEffect, "ADBE Glo2-0002", 30);
            safeSetPropAtTime(glowEffect, "ADBE Glo2-0003", 6, 20);
            safeSetPropAtTime(glowEffect, "ADBE Glo2-0003", 9, 100);
            safeSetProp(glowEffect, "ADBE Glo2-0004", 2.0);
        }
        
        // CC Light Sweep
        var lightSweep = safeAddProperty(createText.Effects, "ADBE CCLightSweep");
        if (!lightSweep) lightSweep = safeAddProperty(createText.Effects, "CC Light Sweep");
        if (lightSweep) {
            safeSetPropAtTime(lightSweep, "ADBE CCLightSweep-0002", 6.25, [-200, 700]);
            safeSetPropAtTime(lightSweep, "ADBE CCLightSweep-0002", 8, [960, 400]);
            safeSetPropAtTime(lightSweep, "ADBE CCLightSweep-0002", 9.25, [2120, 700]);
        }
    }

    // ============================================================
    // Scene 4: 抠图特效
    // ============================================================
    function createScene4(comp) {
        var techBg = comp.layers.addSolid(colors.darkBg, "S4_Tech_BG", compWidth, compHeight, 1);
        techBg.startTime = 10;
        
        // Grid
        var gridEffect = safeAddProperty(techBg.Effects, "ADBE Grid");
        if (gridEffect) {
            safeSetProp(gridEffect, "ADBE Grid-0002", 2);
            safeSetProp(gridEffect, "ADBE Grid-0004", 40);
            safeSetProp(gridEffect, "ADBE Grid-0006", 2);
        }
        
        // 绿色圆形（模拟绿幕）
        var greenCircle = comp.layers.addShape();
        greenCircle.name = "S4_Green_Circle";
        greenCircle.startTime = 10;
        
        var ellipse = safeAddProperty(greenCircle.property("Contents"), "ADBE Vector Shape - Ellipse");
        if (ellipse) safeSetValue(ellipse.property("Size"), [240, 240]);
        
        var fill = safeAddProperty(greenCircle.property("Contents"), "ADBE Vector Graphic - Fill");
        if (fill) safeSetValue(fill.property("Color"), colors.greenScreen);
        
        greenCircle.property("Transform").property("Position").setValue([480, 400]);
        
        // Keylight
        var keylight = safeAddProperty(greenCircle.Effects, "ADBE Keylight 128");
        if (!keylight) keylight = safeAddProperty(greenCircle.Effects, "ADBE Keylight");
        
        // 创建其他形状
        createShape(comp, "S4_Blue_Triangle", [960, 320], "polygon", 3, colors.blue, 10);
        createShape(comp, "S4_Orange_Square", [1440, 400], "rect", 4, colors.orange, 10);
        createShape(comp, "S4_White_Hexagon", [960, 500], "polygon", 6, colors.white, 10);
        
        // 形状入场动画
        animateShapeIn(comp, "S4_Green_Circle", 10);
        animateShapeIn(comp, "S4_Blue_Triangle", 10.1);
        animateShapeIn(comp, "S4_Orange_Square", 10.2);
        animateShapeIn(comp, "S4_White_Hexagon", 10.3);
        
        // 发光圆
        var glowCircle = comp.layers.addSolid(colors.white, "S4_Glow_Reveal", 300, 300, 1);
        glowCircle.startTime = 10;
        glowCircle.property("Transform").property("Position").setValue([480, 400]);
        
        var revealGlow = safeAddProperty(glowCircle.Effects, "ADBE Glo2");
        if (!revealGlow) revealGlow = safeAddProperty(glowCircle.Effects, "ADBE Glow");
        if (revealGlow) {
            safeSetProp(revealGlow, "ADBE Glo2-0003", 60);
            safeSetProp(revealGlow, "ADBE Glo2-0004", 1.5);
        }
        
        var glowScale = glowCircle.property("Transform").property("Scale");
        glowScale.setValueAtTime(12, [70, 70, 100]);
        glowScale.setValueAtTime(13, [130, 130, 100]);
        glowScale.setValueAtTime(14, [100, 100, 100]);
        
        // 文字 "KEYING"
        var keyingText = comp.layers.addText("KEYING");
        keyingText.name = "S4_KEYING";
        keyingText.startTime = 13.25;
        
        var keyingProp = keyingText.property("ADBE Text Properties");
        var keyingDoc = keyingProp.property("ADBE Text Document").value;
        keyingDoc.fontSize = 100;
        keyingDoc.tracking = 30;
        keyingDoc.fillColor = colors.white;
        keyingProp.property("ADBE Text Document").setValue(keyingDoc);
        
        keyingText.property("Transform").property("Position").setValue([960, 640]);
        
        var keyingOpacity = keyingText.property("Transform").property("Opacity");
        keyingOpacity.setValueAtTime(13.25, 0);
        keyingOpacity.setValueAtTime(14.17, 100);
    }

    // ============================================================
    // 辅助函数：创建形状图层
    // ============================================================
    function createShape(comp, name, position, type, sides, color, startTime) {
        var shape = comp.layers.addShape();
        shape.name = name;
        shape.startTime = startTime;
        
        shape.property("Transform").property("Position").setValue(position);
        
        if (type === "ellipse") {
            var ellipse = safeAddProperty(shape.property("Contents"), "ADBE Vector Shape - Ellipse");
            if (ellipse) safeSetValue(ellipse.property("Size"), [240, 240]);
        } else if (type === "rect") {
            var rect = safeAddProperty(shape.property("Contents"), "ADBE Vector Shape - Rect");
            if (rect) {
                safeSetValue(rect.property("Size"), [160, 160]);
                safeSetValue(rect.property("Roundness"), 12);
            }
        } else if (type === "polygon") {
            var poly = safeAddProperty(shape.property("Contents"), "ADBE Vector Shape - Polystar");
            if (poly) {
                safeSetValue(poly.property("Polystar Type"), 1);
                safeSetValue(poly.property("Polystar Sides"), sides);
                safeSetValue(poly.property("Outer Radius"), 90);
            }
        }
        
        var fill = safeAddProperty(shape.property("Contents"), "ADBE Vector Graphic - Fill");
        if (fill) safeSetValue(fill.property("Color"), color);
        
        return shape;
    }

    // ============================================================
    // 辅助函数：形状入场动画
    // ============================================================
    function animateShapeIn(comp, layerName, startTime) {
        var layer = comp.layers.byName(layerName);
        if (!layer) return;
        
        var scale = layer.property("Transform").property("Scale");
        var opacity = layer.property("Transform").property("Opacity");
        var rotation = layer.property("Transform").property("Rotation");
        
        scale.setValueAtTime(startTime, [0, 0, 100]);
        opacity.setValueAtTime(startTime, 0);
        rotation.setValueAtTime(startTime, 180);
        
        var endTime = startTime + 1;
        scale.setValueAtTime(endTime, [100, 100, 100]);
        opacity.setValueAtTime(endTime, 100);
        rotation.setValueAtTime(endTime, 0);
        
        var overshootTime = endTime + 0.17;
        scale.setValueAtTime(overshootTime, [115, 115, 100]);
        scale.setValueAtTime(overshootTime + 0.17, [100, 100, 100]);
    }

    // ============================================================
    // 创建调整图层
    // ============================================================
    function createAdjustmentLayer(comp) {
        var adj = comp.layers.addSolid([0, 0, 0], "Color_Grade", comp.width, comp.height, comp.pixelAspect, comp.duration);
        adj.adjustmentLayer = true;
        adj.name = "Color_Grade";
        adj.moveToEnd();
    }

    // 运行主函数
    main();
}
