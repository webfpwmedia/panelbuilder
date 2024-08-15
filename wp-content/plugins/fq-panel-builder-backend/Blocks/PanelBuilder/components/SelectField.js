import React from 'react'

export default function SelectField({ label, name, options, value, onChange }) {

    const selected = options.find( option => option.key === value );

    return (
        <div>
            <label>{ label }</label>
                <select
                    name={ name }
                    value={ selected ? selected.key : value }
                    onChange={ e => onChange(e.target.value) }
                >
                    { options?.map(option => (
                        <option 
                            key={ option.key }
                            value={ option.key }
                        >{ option?.title }</option>
                    ))}
                </select>
        </div>
    )
}