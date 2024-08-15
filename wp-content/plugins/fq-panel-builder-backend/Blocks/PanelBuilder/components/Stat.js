import React from 'react'

export default function Stat({ label, value }) {

    return (
        <div className="stat">
            <div>
                <label>{ label }</label>
            </div>
            <div className="value">
                { value }
            </div>
        </div>
    )
}