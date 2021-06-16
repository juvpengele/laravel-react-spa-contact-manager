import React from "react";

function Heading({ name, children }) {
    return (
        <div className="flex justify-between pt-8 items-center">
            <span className="text-3xl">{ name }</span>
            { children }
        </div>
    )
}

export default Heading