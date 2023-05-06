import React, {useRef} from "react";
import {useNavigate} from "react-router-dom";

const ForgotPasswordPage = () => {
    const navigate = useNavigate();
    const emailRef = useRef<HTMLInputElement>(null);

    const sendResetPasswordEmail = () => {
        //TODO call api
    }

    return (<div className={'page-container'}>
        <div className={'input-field-container'}>
            <label className={'input-field-label'}>Email</label>
            <div className={'icon-container'}>
                <img src={'/assets/user.png'} alt={'user'} className={'icon'}/>
                <input className={'input-field'} type={'text'} placeholder={'pera@example.com'}/>
            </div>
        </div>

        <div className={'buttons-container'}>
            <input type={'submit'} className={'button-secondary register-button'} onClick={sendResetPasswordEmail}
                   value={'SEND EMAIL'}/>

            <h4 onClick={() => navigate('/login')}>Return to sign in?</h4>
        </div>
    </div>)
}

export default ForgotPasswordPage;
