import React, { useState } from 'react'

import classNames from 'classnames'

export default function Typeahead({ label, name, value, options, onChange }) {

    const [showOptions, setShowOptions] = useState(false)
    const [filter, setFilter] = useState(value ? options?.find(item => item?.key)?.title : '')
    const filteredOptions = filter?.trim() !== '' ? options?.filter(option => option?.title?.toLowerCase().includes(value?.toLowerCase())) : options

    return (
        <div className="typeahead">
            <label>{ label }</label>
            <div className="input-button">
                <input
                    type="text"
                    name={ name }
                    value={ filter }
                    onChange={ e => setFilter(e.target.value) }
                    onClick={ () => setShowOptions(true) }
                    onFocus={ () => setShowOptions(true) }
                />
                <i className="far fa-search" onClick={ () => setShowOptions(!showOptions) }></i>
            </div>

            { showOptions && (
                <div className="options">
                    { filteredOptions?.map(option => (
                        <button 
                            className={ classNames({
                                'selected': option.key === value
                            })}
                            onClick={ () => {
                                onChange(option.key) 
                                setFilter(option.title)
                                setShowOptions(false)
                            }}
                        >
                            { value === option?.key ? <i className="fas fa-check"></i> : null }
                            { option?.title }
                        </button>
                    ))}
                </div>
            )}
        </div>
    )
}