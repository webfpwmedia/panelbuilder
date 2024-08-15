import { CubicEase, EasingFunction } from "@babylonjs/core/Animations/easing"

import { Animation } from "@babylonjs/core/Animations/animation"

const FRAMES_PER_SECOND = 60

class PanelPreview {

    constructor({ id }) {

        const canvas = document.getElementById(id)
        const engine = new BABYLON.Engine(canvas, true)

        this.defaultCore = 'armorcore'

        this.baseUrl = '/wp-content/plugins/fq-panel-builder-backend'
        this.engine = engine
        this.canvas = canvas
        this.scene = this.setupScene()
        this.camera = null
        this.core = this.defaultCore
        this.coreDepth = 1 / 12 * .75
        this.numCores = this.numberOfCoreLayers()
        this.cores = []
        this.faceMatch = null
        this.numFlitches = 4
        this.veneerDepth = 0.005
        this.sheetWidth = 4
        this.sheetLength = 8
        this.cameraDistance = 4.6
        this.faceSpecies = null
        this.backSpecies = null
        this.showFrontVeneer = false
        this.showBackVeneer = false
        this.cornerTarget = new BABYLON.Vector3(0, 0, -1.5)
        this.centerTarget = new BABYLON.Vector3(0, 0, 0)
        this.faceGrainDirection = 'length'
        this.backGrainDirection = 'length',
        this.focus = 'corner'
        this.frontVeneer = null
        this.backVeneer = null

        this.focusPoints = [
            {
                key: 'corner',
                alpha: Math.PI / 0.8,
                beta: Math.PI / 2.1,
            },
            {
                key: 'side',
                alpha: Math.PI / 1,
                beta: Math.PI / 3,
            },
            {
                key: 'front',
                alpha: Math.PI / 1,
                beta: -1,
            },
            {
                key: 'back',
                alpha: Math.PI / 1,
                beta: Math.PI, 
            },
        ]

        this.engine.displayLoadingUI()

        this.setupCamera()
        this.setupLighting()
        this.setupPanel()

        this.engine.hideLoadingUI()

        this.engine.runRenderLoop(() => {
            this.scene.render()
        })
    }

    numberOfCoreLayers() {
        if (this.core !== 'composite') {
            this.numCores = 7
        } else {
            this.numCores = 1
        } 
    }

    update(options) {

        console.log( options );

        const size = options?.size
        const sizeParts = size.split('x')

        const thickness = options?.thickness ? parseFloat(options?.thickness) : .75

        this.core = options?.core
        this.coreDepth = 1 / 12 * thickness
        this.sheetWidth = parseFloat(sizeParts[0])
        this.sheetLength = parseFloat(sizeParts[1])
        this.frontVeneer = options?.frontVeneer
        this.backVeneer = options?.backVeneer
        this.faceSpecies = options?.faceSpecies
        this.backSpecies = options?.backSpecies
        this.faceMatch = options?.faceMatch
        this.faceGrainDirection = options?.faceGrainDirection

        this.numberOfCoreLayers()
        // if (this.core !== 'composite') {
        //     this.numCores = 7
        // } else {
        //     this.numCores = 1
        // }
        
        const newFocus = this.getCameraFocus(options?.step)
        const shouldAnimateCameraFocus = this.focus !== newFocus
        let radius = this.cameraDistance 

        if (newFocus === 'side') {
            radius = size === '4x8' ? 10 : 12
        } else if (newFocus === 'corner') {
            radius = size === '4x8' ? 4.6 : 6
        } else {
            radius = size === '4x8' ? 6.6 : 9
        }

        if (shouldAnimateCameraFocus || radius !== this.cameraDistance) {
            this.moveCamera({ focus: newFocus, radius: radius, fromFrame: 0, toFrame: 100 })
            this.focus = newFocus
        }

        if (options?.step >= 3) {
            this.showFrontVeneer = true
            this.showBackVeneer = true
        }

        this.updateCores()

        this.clearVeneeers()

        if (this.showFrontVeneer && this.faceSpecies) {
            this.createVeneers({ isFace: true })
        }

        if (this.showBackVeneer && this.backSpecies) {
            this.createVeneers({ isFace: false })
        }
    }

    getCameraFocus(step) {
        switch (step) {
            case 1:
            case 2:
                return 'corner'
                
            case 3:
                return 'front'

            case 4:
                return 'back'

            default:
                return 'side'
        }
    }

    setupScene() {

        let scene = new BABYLON.Scene(this.engine);
        const hdri = this.baseUrl + '/images/hdri/ballroom_1k.hdr'
        scene.environmentTexture = new BABYLON.HDRCubeTexture(hdri, scene, 128, false, false);
        scene.environmentIntensity = 1;
        scene.clearColor = new BABYLON.Color3(250 / 255, 250 / 255, 250 / 255);

        return scene;
    }

    reset() {
        this.updateCores()
        this.clearVeneeers()
    }

    setupCamera() {

        // Start with a side shot.
        const focus = this.focusPoints[0]

        this.camera = new BABYLON.ArcRotateCamera(
            'Camera',
            focus?.alpha,
            focus?.beta,
            this.cameraDistance,
            this.cornerTarget,
            this.scene
        );
    }

    createAnimation({ property, from, to }) {
        
        const ease = new CubicEase();
        ease.setEasingMode(EasingFunction.EASINGMODE_EASEINOUT);

        const animation = Animation.CreateAnimation(
            property,
            Animation.ANIMATIONTYPE_FLOAT,
            FRAMES_PER_SECOND,
            ease
        );
        animation.setKeys([
            {
                frame: 0,
                value: from,
            },
            {
                frame: 100,
                value: to,
            },
        ]);

        return animation;
    }

    moveCamera({ focus, radius, fromFrame, toFrame }) {

        this.camera.animations = []

        // Move the target.
        this.camera.target = focus === 'corner' ? this.cornerTarget : this.centerTarget

        if (radius && radius != this.cameraDistance) {
            this.camera.animations.push(this.createAnimation({
                property: 'radius',
                from: this.camera.radius,
                to: radius
            }))
        }

        if (focus && focus != this.focus) {
            const oldFocusPoint = this.focusPoints.find(point => point.key === this.focus)
            const newFocusPoint = this.focusPoints.find(point => point.key === focus)

            this.camera.animations.push(this.createAnimation({
                property: 'alpha',
                from: oldFocusPoint.alpha,
                to: newFocusPoint.alpha
            }))
            this.camera.animations.push(this.createAnimation({
                property: 'beta',
                from: oldFocusPoint.beta,
                to: newFocusPoint.beta
            }))
        }

        this.cameraDistance = radius
        this.scene.beginAnimation(this.camera, fromFrame, toFrame, false, 4 )
    }

    setupLighting() {

        new BABYLON.HemisphericLight(
            'light1',
            new BABYLON.Vector3(1, 30, 0),
            this.scene
        );
        new BABYLON.HemisphericLight(
            'light2',
            new BABYLON.Vector3(1, -30, 0),
            this.scene
        );
    }

    setupPanel() {

        this.updateCores()
    }

    updateCores() {

        // console.log( 'updating cores' );

        // Create the cores.
        this.cores = []

        // Remove the old meshes too.
        const coreMeshes = this.scene.meshes.filter(item => item?.name?.includes('core'))
        coreMeshes.forEach(item => item?.dispose())

        // Delete the old core materials.
        const coreMaterials = this.scene.materials.filter(item => item?.name?.includes('core'))
        coreMaterials.forEach(item => item?.dispose())

        for (let i = 0; i < this.numCores; i++) {
            this.cores.push(this.createCore(i));
        };
    }

    createCore(index) {

        // console.log( 'creating core' );

        let core = BABYLON.MeshBuilder.CreateBox(
            'core_' + index,
            {
                height: this.coreDepth / this.numCores,
                width: this.sheetWidth,
                depth: this.sheetLength,
            },
            this.scene
        );
        core.position = new BABYLON.Vector3(this.coreXOffset(), this.calculateCoreYOffset(index), 0);
        core.material = this.generateCoreMaterial(index);

        return core;
    }

    coreXOffset() {
        return 0
    }

    calculateCoreYOffset(index) {

        let offset = (index * (this.coreDepth / this.numCores));
        let screenOffset = this.numCores > 1 ? this.coreDepth / 2 : 0;

        return offset - screenOffset;
    }

    generateCoreMaterial(index) {

        let material = new BABYLON.PBRMetallicRoughnessMaterial('pbr_core_' + index, this.scene);

        // Base texture will depend on core and index.
        if (this.core === 'composite') {
            console.log( 'we have comp core' );

            const coreImage = this.baseUrl + `/images/cores/${this.core || this.defaultCore}.jpg`
            material.baseTexture = new BABYLON.Texture(coreImage, this.scene);
        } else {
            console.log( 'not comp core' );

            const oddMaterial = new BABYLON.Color3(0.6, 0.47, 0.3)
            const evenMaterial = new BABYLON.Color3(0.84, 0.71, 0.52)
            material.baseColor = index % 2 === 0 ? oddMaterial : evenMaterial
        }

        material.metallic = 0.2;
        material.roughness = 0.9;

        // console.log( coreImage, 'core image' )
        // console.log( material );

        return material;
    }

    clearVeneeers() {

        // Remove old veneers.
        const veneers = this.scene.meshes.filter(item => item?.name?.includes('veneer'))
        veneers.forEach(item => item.dispose())

        const materials =  this.scene.materials.filter(item => item?.name?.includes('veneer'))
        materials.forEach(item => item.dispose())
    }

    createVeneers({ isFace }) {
        
        // Create the veneers.
        for (let i = 0; i < this.numFlitches; i++) {
            this.createVeneerFlitch(i, isFace)
        }
    }

    createVeneerFlitch(index, isFace) {

        const isLength = this.faceGrainDirection === 'length'
        const flitchWidth = isLength ? this.sheetWidth / this.numFlitches : this.sheetWidth

        const flitchSize = {
            height: this.veneerDepth,
            width: flitchWidth,
            depth: isLength ? this.sheetLength : this.sheetLength / this.numFlitches,
        }

        let flitch = BABYLON.MeshBuilder.CreateBox(
            'veneer_flitch_' + (isFace ? 'face' : 'back') + '_' + index,
            flitchSize,
            this.scene
        )

        let flitchXOffset = (flitchWidth * index) - (this.sheetWidth / 2) + (flitchWidth / 2)
        let flitchYOffset = (this.coreDepth / 2) + (this.veneerDepth / 2)
        let flitchZOffset = 0

        if (!isFace) {
            flitchYOffset = -1 * flitchYOffset
        }

        if (!isLength) {
            flitchXOffset = 0
            flitchZOffset = (this.sheetLength / 2) - (flitchSize.depth / 2) - (index * flitchSize.depth)
        }

        flitch.position = new BABYLON.Vector3(flitchXOffset, flitchYOffset, flitchZOffset);
        flitch.material = this.generateFlitchMaterial(index, isFace, isLength)
    }

    generateFlitchMaterial(index, isFace, isLength = true) {
            
            const vScale = 1
            let material = new BABYLON.PBRMetallicRoughnessMaterial('pbr_veneer_' + index, this.scene);
            const veneerImage = this.baseUrl + `/images/veneers/${ isFace ? this.frontVeneer : this.backVeneer }.jpg`
            material.baseTexture = new BABYLON.Texture(veneerImage, this.scene);
            material.baseTexture.vScale = vScale

            // Offset the texture.
            material.baseTexture.vOffset = 0 

            // material.baseTexture.uScale = uScale
            material.baseTexture.wAng = Math.PI / 2

            if (!isLength) {
                material.baseTexture.wAng += Math.PI / 2
            }

            const isBook = (this.faceMatch === 'book' && isFace) || (this.backMatch === 'book' && !isFace)

            if (isBook) {
                if (index == 0 || index == 3) {
                    const scale = vScale * -1

                    if (isLength) {
                        material.baseTexture.vScale = scale
                    } else {
                        material.baseTexture.uScale = scale
                    }
                }
            }

            const isRandom = (this.faceMatch === 'random' && isFace) || (this.backMatch === 'random' && !isFace)

            if (isRandom) {
                const min = 1 
                const max = 2
                const randomValue1 = Math.floor(Math.random() * (max - min + 1)) + min
                const scale1 = randomValue1 % 2 === 0 ? vScale : vScale * -1

                if (isLength) {
                    material.baseTexture.vScale = scale1
                } else {
                    material.baseTexture.uScale = scale1
                }
            }

            material.metallic = 0.2;
            material.roughness = 0.9;
    
            return material;
    }


}

export default PanelPreview