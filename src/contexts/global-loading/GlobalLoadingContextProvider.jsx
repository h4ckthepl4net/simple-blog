import React, {useState} from "react";
import GlobalLoadingContext from "./GlobalLoadingContext";

export function LoadingContextProvider(props) { // TODO use redux instead

    const [isLoading, setIsLoading] = useState(props.value?.loading ?? true);

    const startLoading = props.value?.startLoading ?? (() => {
        setIsLoading(true);
    });

    const stopLoading = props.value?.stopLoading ?? (() => {
        setIsLoading(false);
    });

    return (
        <GlobalLoadingContext.Provider value={{
            loading: isLoading,
            startLoading,
            stopLoading,
        }}>
            {isLoading && <div>Loading the page</div>}
            {props.children}
        </GlobalLoadingContext.Provider>
    )
}