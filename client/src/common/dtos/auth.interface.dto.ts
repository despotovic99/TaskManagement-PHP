export interface LoginDto {
    username: string,
    password: string
}

export interface RegisterDto {
    username: string,
    email: string,
    password: string,
    confirmedPassword: string,
    firstName: string,
    lastName: string,
    phoneNumber?: string
    dateOfBirth?: string
}
