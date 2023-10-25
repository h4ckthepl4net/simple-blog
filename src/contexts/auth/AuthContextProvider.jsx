import {useContext, useState, useEffect} from "react";
import AuthContext from "./AuthContext";
import GlobalLoadingContext from "../global-loading/GlobalLoadingContext";

const AuthContextProvider = (props) => { // TODO use redux instead

    const loadingContext = useContext(GlobalLoadingContext);

    const [currentUser, setCurrentUser] = useState(props.value?.currentUser ?? null);
    const [users, setUsers] = useState(props.value?.users ?? []);

    const signIn = props.value?.signIn ?? (async (email, password) => {
        loadingContext?.startLoading();
        try {
            const user = await AuthService.signIn(email, password);
            if (user) {
                setCurrentUser(user);
                return true;
            }
            return false;
        } finally {
            loadingContext?.stopLoading();
        }
    });
    const signOut = props.value?.signOut ?? (async () => {
        await AuthService.signOut();
        setCurrentUser(null);
    });
    const fetchUser = props.value?.fetchUser ?? (async (globalLoading = false) => {
        if (globalLoading) {
            loadingContext?.startLoading();
        }
        try {
            const user = await AuthService.fetchUser();
            setCurrentUser(user);
            return user;
        } finally {
            if(globalLoading) {
                loadingContext?.stopLoading();
            }
        }
    });
    const getToken = props.value?.getToken ?? (async () => {
        return "";
    });

    const [initializing, setInitializing] = useState(true);

    useEffect(() => {
        (async () => {
            try {
                await fetchUser(true);
            } catch(error) {
                // TODO: Handle error or ignore it
            } finally {
                setInitializing(false);
            }
        })();
    }, []);

    return (
        <AuthContext.Provider value={{
            users,
            currentUser,
            signIn,
            signOut,
            fetchUser,
            getToken,
        }}>
            {!initializing && props.children}
        </AuthContext.Provider>
    )
}