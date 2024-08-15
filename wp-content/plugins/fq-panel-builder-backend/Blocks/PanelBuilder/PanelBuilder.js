import * as BABYLON from '@babylonjs/core/Legacy/legacy';

import React, { createRef, useEffect, useState } from 'react'

import PanelPreview from './PanelPreview';
import SelectField from './components/SelectField'
import Stat from './components/Stat';
import Typeahead from './components/Typeahead';
import axios from 'axios'
import classnames from 'classnames'

export default function PanelBuilder() {

    const [builderData, setBuilderData] = useState(null)
    const [step, setStep] = useState(1)
    const [core, setCore] = useState(null)
    const [size, setSize] = useState(null)
    const [thickness, setThickness] = useState(null)
    const [faceSpecies, setFaceSpecies] = useState(null)
    const [faceCut, setFaceCut] = useState(null)
    const [faceMatch, setFaceMatch] = useState(null)
    const [faceGrade, setFaceGrade] = useState(null)
    const [faceGrain, setFaceGrain] = useState(null)
    const [backSpecies, setBackSpecies] = useState(null)
    const [backCut, setBackCut] = useState(null)
    const [backMatch, setBackMatch] = useState(null)
    const [backGrade, setBackGrade] = useState(null)
    const scrollRef = createRef()

    const grainOptions = [
        { key: 'length', title: 'Length' },
        { key: 'width', title: 'Width' },
    ]

    useEffect(() => {
        getData().then(() => {
            window.panelPreview = new PanelPreview({ id: 'panel-preview-canvas' })
            // updatePreview()
        })
    }, [])


    useEffect(() => {
        updatePreview()
    }, [core, thickness, size, step, faceSpecies, backSpecies, faceMatch, faceCut, backCut, backMatch, faceGrain])

    useEffect(() => {
        if (!faceSpecies) {
            setFaceSpecies(calculateSpeciesOptions({ isFace: true })?.find(item => item)?.key)
        }

        if (!backSpecies) {
            setBackSpecies(calculateSpeciesOptions({ isFace: false })?.find(item => item)?.key)
        }
    }, [core, thickness, size, step, faceMatch, backMatch])

    const getData = () => {
        return new Promise((resolve, reject) => {
            axios.get('/wp-json/panel-builder/v1/all-species')
                .then(response => {
                    const builderData = response?.data 
                    const { settings } = builderData

                    // Store all the data.
                    setBuilderData(builderData)

                    // Set defaults for all of the options.
                    setCore(settings?.core?.find(item => item)?.key)
                    setSize(settings?.size?.find(item => item)?.key)
                    setThickness(settings?.thickness?.find(item => item.key === '.75')?.key)
                    setFaceCut(settings?.cut?.find(item => item)?.key)
                    setFaceMatch(settings?.match?.find(item => item)?.key)
                    setFaceGrade(settings?.grade?.find(item => item)?.key)
                    setFaceGrain(grainOptions[0]?.key)
                    setBackCut(settings?.cut?.find(item => item)?.key)
                    setBackMatch(settings?.match?.find(item => item)?.key)
                    setBackGrade(settings?.back_grade?.find(item => item)?.key)

                    resolve()

                }).catch(error => {
                    console.error('fail whale', error)
                    reject()
                }) 
        })
        
    }

    const updatePreview = () => {
        window.panelPreview?.update({
            core,
            thickness,
            size,
            step,
            faceSpecies,
            backSpecies,
            frontVeneer: `${faceSpecies}-${faceCut}-${faceGrade}`,
            backVeneer: `${backSpecies}-${backCut}-${backGrade}`,
            faceMatch,
            backMatch,
            faceGrainDirection: faceGrain,
            backGrainDirection: faceGrain,
        })
    }

    const canGoToNextStep = () => {

        switch (step) {
            case 1:
                return core !== null

            case 2:
                return size !== null && thickness !== null

            case 3:
                return faceSpecies !== null && faceCut !== null && faceMatch !== null && faceGrade !== null && faceGrain !== null

            case 4:
                return backSpecies !== null && backCut !== null && backMatch !== null && backGrade !== null 

            default:
                // No default case.
        }
    }

    const goToNextStep = e => {
        e.preventDefault()
        setStep(step + 1)
        scrollToTopOfStep()
    }

    const goBack = e => {
        e.preventDefault()
        setStep(step - 1)
        scrollToTopOfStep()
    }

    const startOver = e => {
        e.preventDefault()
        getData().then(() => {
            window.panelPreview?.reset()
        })
        setStep(1)
        scrollToTopOfStep()
    }

    const scrollToTopOfStep = () => {
        const top = scrollRef.current.offsetTop
        const offset = 100

        window.scrollTo({
            top: top - offset,
            behavior: 'smooth'
        })
    }

    const calculateSpeciesOptions = ({ isFace, data }) => {

        const settings = data?.settings || builderData?.settings

        let options = settings?.species.filter(item => {
            let available = item.cores_available.includes(core) &&
                            item.sizes_available.includes(size) &&
                            item.thicknesses_available.includes(thickness) &&
                            item.cuts_available.includes(isFace ? faceCut : backCut) &&
                            item.matches_available.includes(isFace ? faceMatch : backMatch) &&
                            !item.currently_unavailable

            return isFace ? available && item.grades_available.includes(faceGrade) : available && item.back_grades_available.includes(backGrade) 
        })

        if (options?.length === 0) {
            options.push({ key: '', title: 'None available with selection' })
        }

        // Is the currently selected species still available?
        if (!options?.find(item => item.key === (isFace ? faceSpecies : backSpecies)) && (isFace ? faceSpecies : backSpecies)) {
            setFaceSpecies(null)
        }

        return options
    }

    const download = e => {
        e.preventDefault()
        axios.post('/wp-json/panel-builder/v1/csi-spec', {

        }, {
            responseType: 'blob'
        }).then(response => {

            // create file link in browser's memory
            const href = URL.createObjectURL(response.data);

            // create "a" HTML element with href to file & click
            const link = document.createElement('a');
            link.href = href;
            link.setAttribute('download', 'CSISpec.doc'); //or any other extension
            document.body.appendChild(link);
            link.click();

            // clean up "a" element & remove ObjectURL
            document.body.removeChild(link);
            URL.revokeObjectURL(href);

        }).catch(error => console.error(error))
    }

    if (!builderData) {
        return <div>Loading...</div>
    }

    return (
        <div className="panel-builder">
            <div className="preview">
                <canvas id="panel-preview-canvas" className="w-full h-full"></canvas>
            </div>

            <div className="controls">
                <div ref={ scrollRef }></div>
                { step === 1 && (
                    <div>
                        <h2>1. Core material</h2>
                        <div className="button-group">
                            { builderData?.settings?.core?.map(availableCore => (
                                <button 
                                    key={ availableCore?.key } 
                                    className={ classnames({ 'neutral': core !== availableCore?.key }) }
                                    onClick={ () => setCore(availableCore?.key) }
                                >
                                    { availableCore?.title }
                                </button>
                            ))}
                        </div>
                    </div>
                )}

                { step === 2 && (
                    <div>
                        <h2>2. Panel size</h2>

                        <SelectField
                            label="SIZE"
                            name="size"
                            options={ builderData?.settings?.size }
                            value={ size }
                            onChange={ setSize }
                        />

                        <SelectField
                            label="THICKNESS"
                            name="thickness"
                            options={ builderData?.settings?.thickness }
                            value={ thickness }
                            onChange={ setThickness }
                        />
                    </div>    
                )}

                { step === 3 && (
                    <div>
                        <h2>3. Face Veneer</h2>

                        <Typeahead 
                            label="SPECIES"
                            name="face-species"
                            options={ calculateSpeciesOptions({ isFace: true }) }
                            value={ faceSpecies }
                            onChange={ setFaceSpecies }
                        />

                        <SelectField 
                            label="CUT"
                            name="face-cut"
                            options={ builderData?.settings?.cut }
                            value={ faceCut }
                            onChange={ setFaceCut }
                        />

                        <SelectField 
                            label="MATCH"
                            name="face-match"
                            options={ builderData?.settings?.match }
                            value={ faceMatch }
                            onChange={ setFaceMatch }
                        />

                        <SelectField 
                            label="GRADE"
                            name="face-grade"
                            options={ builderData?.settings?.grade }
                            value={ faceGrade }
                            onChange={ setFaceGrade }
                        />

                        <SelectField 
                            label="GRAIN DIRECTION"
                            name="face-grain"
                            options={ grainOptions }
                            value={ faceGrain }
                            onChange={ setFaceGrain }
                        />
                    </div>
                )}

                { step === 4 && (
                    <div>
                        <h2>4. Back Veneer</h2>

                        <Typeahead 
                            label="SPECIES"
                            name="back-species"
                            options={ calculateSpeciesOptions({ isFace: false }) }
                            value={ backSpecies }
                            onChange={ setBackSpecies }
                        />

                        <SelectField 
                            label="CUT"
                            name="back-cut"
                            options={ builderData?.settings?.cut }
                            value={ backCut }
                            onChange={ setBackCut }
                        />

                        <SelectField 
                            label="MATCH"
                            name="back-match"
                            options={ builderData?.settings?.match }
                            value={ backMatch }
                            onChange={ setBackMatch }
                        />

                        <SelectField 
                            label="GRADE"
                            name="back-grade"
                            options={ builderData?.settings?.back_grade }
                            value={ backGrade }
                            onChange={ setBackGrade }
                        />
                    </div>
                )}

                { step === 5 && (
                    <div>
                        <h2>5. Your Panel</h2>
                        <h3>Download your spec sheet.</h3>

                        <div className="box">
                            <Stat label="Core" value={ core } />
                            <Stat label="Panel Size" value={ size } />
                            <Stat label="Thickness" value={ thickness } />
                            <Stat label="Face Veneer" value={  
                                <>
                                    <span>{ faceCut }-cut { faceSpecies }</span><br/>
                                    <span>{ faceMatch } match</span><br/>
                                    <span>Grade: { faceGrade }</span><br/>
                                    <span>Grain direction: { faceGrain }</span><br/>
                                </>
                            } /> 
                            <Stat label="Back Veneer" value={  
                                <>
                                    <span>{ backCut }-cut { backSpecies }</span><br/>
                                    <span>{ backMatch } match</span><br/>
                                    <span>Grade: { backGrade }</span><br/>
                                    <span>Grain direction: { faceGrain }</span><br/>
                                </>
                            } /> 
                        </div>
                    </div>    
                )}

                <footer>
                    { step !== 1 && (
                        <button onClick={ e => goBack(e) } className="neutral">
                            <i className="left far fa-arrow-left"></i>
                            Back
                        </button>
                    )}

                    { step !== 5 && (
                        <button disabled={ !canGoToNextStep() } onClick={ e => goToNextStep(e) }>
                            Next
                            <i className="right far fa-arrow-right"></i>
                        </button>
                    )}

                    { step === 5 && (
                        <button className="neutral" onClick={ e => startOver(e) }>
                            Start Over
                            <i className="right far fa-repeat"></i>
                        </button>
                    )}

                    { step === 5 && (
                        <button onClick={ e => download(e) }>
                            Download CSI Spec
                            <i className="right far fa-download"></i>
                        </button>
                    )}
                </footer>
            </div>
        </div>
    )
}